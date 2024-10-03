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

        DB::statement('CREATE INDEX tasks_description_index ON tasks (description(255))');

    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['task_status']);
            $table->dropIndex(['due_date']);
        });

        DB::statement('DROP INDEX tasks_description_index ON tasks');

    }
};
