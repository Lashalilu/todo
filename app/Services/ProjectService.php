<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function index($request): LengthAwarePaginator
    {
        return Project::query()->paginate($request->per_page ?? 10);
    }

    public function store($data): void
    {
        $project = Project::query()->create($data);

        if (!empty($data['users'])) {
            $project->users()->attach($data['users']);
        }
    }

    public function update($project, $data): void
    {
        $project->update($data);

        $project->users()->sync($data['users'] ?? []);
    }

    public function delete($project): void
    {
        $project->users()->detach();
        $project->delete();
    }

}
