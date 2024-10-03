<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->index('title');
            $table->index('task_status');
            $table->index('due_date');
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->index([DB::raw('description(255)')], 'tasks_description_index');
            }
        });

    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['task_status']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (DB::getDriverName() !== 'sqlite') {
                $table->dropIndex('tasks_description_index');
            }
        });
    }
};
