<?php

namespace Tests\Unit;

use App\Http\Requests\Task\IndexTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TaskService $taskService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskService = new TaskService();
    }

    public function testIndex(): void
    {
        Task::factory()->count(15)->create();

        $request = new IndexTaskRequest([
            'per_page' => 10,
        ]);

        $result = $this->taskService->index($request);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
        $this->assertCount(10, $result->items());
    }

    public function testStore(): void
    {
        $data = Task::factory()->make()->toArray();

        $this->taskService->store($data);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testUpdate(): void
    {
        $task = Task::factory()->create();
        $data = ['title' => 'Updated Title'];

        $this->taskService->update($task, $data);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDelete(): void
    {
        $task = Task::factory()->create();

        $this->taskService->delete($task);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
