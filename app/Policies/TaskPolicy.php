<?php

namespace App\Policies;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id && $task->isCompleted();
    }

    public function complete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id && !$task->subtasks()->whereIn('status', [TaskStatus::TODO, TaskStatus::IN_PROGRESS])->exists();
    }
}
