<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function projectSummary(): JsonResponse
    {
        $projects = Project::with('tasks')->get();

        $summary = $projects->map(function ($project) {
            $totalTasks = $project->tasks->count();
            $completedTasks = $project->tasks->where('task_status', TaskStatusEnum::COMPLETED->value)->count();
            $completedPercentage = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

            return [
                'project_id' => $project->id,
                'project_name' => $project->name,
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'completed_percentage' => $completedPercentage,
            ];
        });

        return response()->json(['data' => $summary]);
    }
}
