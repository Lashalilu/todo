<?php

namespace App\Services;

use App\Http\Requests\Task\IndexTaskRequest;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function index(IndexTaskRequest $request): LengthAwarePaginator
    {
        return Task::query()
            ->with('project')
            ->where(function ($query) use ($request) {
                $query->when($request->keyword, function ($query, $keyword) {
                    $query->whereAny(['title', 'description'], 'like', "%{$keyword}%");
                }
                )
                    ->when($request->task_status, fn($query, $task_status) => $query->where('task_status', $task_status))
                    ->when($request->due_date, fn($query, $due_date) => $query->whereDate('due_date', $due_date));
            })
            ->paginate($request->per_page ?? 10);
    }

    public function store($data): void
    {
        Task::create($data);
    }

    public function update($task, $data): void
    {
        $task->update($data);
    }

    public function delete($task): void
    {
        $task->delete();
    }
}
