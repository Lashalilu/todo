<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\Task\IndexTaskRequest;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\Task\IndexTaskResource;
use App\Http\Resources\Task\ShowTaskResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function index(IndexTaskRequest $request): AnonymousResourceCollection
    {
        return IndexTaskResource::collection(
            $this->taskService->index($request)
        );
    }

    public function create(): JsonResponse
    {
        return response()->json(
            [
                'data' => [
                    'project_id' => Project::query()->get(['id', 'name']),
                    'task_status' => TaskStatusEnum::list(),
                    'users' => User::query()->get(['id', 'name'])
                ]
            ]
        );
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $this->taskService->store($request->validated());

        });

        return response()->json(
            [
                "success" => true,
                "message" => "Task created successfully",
            ]
        );
    }

    public function show(Task $task): AnonymousResourceCollection
    {
        return ShowTaskResource::collection($task->load('project'));
    }

    public function edit(Task $task): JsonResponse
    {
        return response()->json(
            [
                'data' => [
                    'task' => ShowTaskResource::make($task->load('project')),
                    'project_id' => Project::query()->get(['id', 'name']),
                    'task_status' => TaskStatusEnum::list(),
                    'users' => User::query()->get(['id', 'name'])
                ]
            ]
        );
    }

    public function update(Task $task, UpdateTaskRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request, $task) {
            $this->taskService->update($task, $request->validated());

        });

        return response()->json(
            [
                "success" => true,
                "message" => "Task updated successfully",
            ]
        );
    }

    public function destroy(Task $task): JsonResponse
    {
        DB::transaction(function () use ($task) {
            $this->taskService->delete($task);

        });

        return response()->json(
            [
                "success" => true,
                "message" => "Task deleted successfully",
            ]
        );
    }
}
