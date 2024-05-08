<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function (User $user) {
            Task::factory()->count(5)->create(['user_id' => $user->id])->each(function (Task $task) {
                Task::factory()->count(2)->create(['parent_id' => $task->id, 'user_id' => $task->user_id]);
            });
        });
    }
}
