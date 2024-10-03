<?php

namespace App\Console\Commands;

use App\Enums\TaskStatusEnum;
use App\Jobs\SendTaskDueEmail;
use App\Mail\TaskDueToday;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DueDateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'due-date:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command check due date of the task and send email to the user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tasks = Task::whereDate('due_date', now()->toDateString())
            ->where('task_status', '!=', TaskStatusEnum::COMPLETED->value)
            ->with('user')
            ->get();

        foreach ($tasks as $task) {
            SendTaskDueEmail::dispatch($task);
        }
    }
}
