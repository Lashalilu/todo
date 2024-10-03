<?php

namespace App\Http\Controllers;

use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\Project\IndexProjectResource;
use App\Http\Resources\Project\ShowProjectResource;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService)
    {
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        return IndexProjectResource::collection(
            $this->projectService->index($request)
        );
    }

    public function create(): JsonResponse
    {
        return response()->json(
            [
                'data' => [
                    'users' => User::query()->get(['id', 'name']),
                ]
            ]
        );
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $this->projectService->store($request->validated());

        });

        return response()->json(
            [
                "success" => true,
                "message" => "Project created successfully",
            ]
        );
    }

    public function show(Project $project): ShowProjectResource
    {
        return ShowProjectResource::make($project->load('users', 'tasks'));
    }

    public function edit(Project $project): JsonResponse
    {
        return response()->json(
            [
                'data' => [
                    'project' => IndexProjectResource::make($project),
                    'users' => User::query()->get(['id', 'name']),
                ]
            ]
        );
    }

    public function update(Project $project, UpdateProjectRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request, $project) {
            $this->projectService->update($project, $request->validated());
        });

        return response()->json(
            [
                "success" => true,
                "message" => "Project updated successfully",
            ]
        );
    }

    public function destroy(Project $project): JsonResponse
    {
        DB::transaction(function () use ($project) {
            $this->projectService->delete($project);
        });

        return response()->json(
            [
                "success" => true,
                "message" => "Project deleted successfully",
            ]
        );
    }
}
