<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'task_status' => $this->faker->randomElement(['pending', 'completed']),
            'due_date' => $this->faker->dateTime,
            'project_id' => \App\Models\Project::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
