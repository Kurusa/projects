<?php

namespace App\Services;

use App\Enums\TaskStatus;
use App\Exceptions\CannotCompleteTaskException;
use App\Exceptions\CannotDeleteTaskException;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function search(User $user, array $filters): Collection
    {
        $query = $user->tasks();

        $query->status($filters['status'] ?? null)
            ->priority($filters['priority'] ?? null)
            ->textSearch($filters['text'] ?? null);

        $sortBy = $filters['sortBy'] ?? 'created_at';

        $sortDirection = $filters['sortDirection'] ?? 'asc';

        $query->orderBy($sortBy, $sortDirection);

        return $query->get();
    }

    public function store(User $user, array $data): Task
    {
        return $user->tasks()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'priority' => $data['priority'],
            'parent_id' => $data['parent_id'] ?? null,
        ]);
    }

    public function complete(Task $task): Task
    {
        if ($task->subtasks()->where('status', TaskStatus::TODO)->exists()) {
            throw new CannotCompleteTaskException('All subtasks must be completed before marking this task as completed.');
        }

        $task->update([
            'status' => TaskStatus::COMPLETE,
            'completed_at' => now(),
        ]);

        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete(Task $task): void
    {
        if ($task->isCompleted()) {
            throw new CannotDeleteTaskException("Cannot delete completed task.");
        }

        $task->delete();
    }
}
