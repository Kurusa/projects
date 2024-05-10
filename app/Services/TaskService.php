<?php

namespace App\Services;

use App\DTO\TaskDTO;
use App\Enums\TaskStatus;
use App\Exceptions\CannotCompleteTaskException;
use App\Exceptions\CannotDeleteTaskException;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;

class TaskService
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(User $user, array $filters): array
    {
        $tasks = $this->repository->search($user, $filters);

        return TaskDTO::collection($tasks->map(fn(Task $task) => TaskDTO::fromModel($task))->all());
    }

    public function store(User $user, TaskDTO $data): TaskDTO
    {
        $task = $user->tasks()->create($data->only('title', 'description', 'priority', 'parent_id')->toArray());

        return TaskDTO::fromModel($task);
    }

    public function complete(Task $task): TaskDTO
    {
        if ($task->subtasks()->whereIn('status', [TaskStatus::TODO, TaskStatus::IN_PROGRESS])->exists()) {
            throw new CannotCompleteTaskException('All subtasks must be completed before marking this task as completed.');
        }

        $task->update([
            'status' => TaskStatus::COMPLETE,
            'completed_at' => now(),
        ]);

        return TaskDTO::fromModel($task);
    }

    public function update(Task $task, TaskDTO $data): TaskDTO
    {
        $task->update($data->only('title', 'description', 'priority', 'parent_id')->toArray());

        return TaskDTO::fromModel($task);
    }

    public function delete(Task $task): void
    {
        if ($task->isCompleted()) {
            throw new CannotDeleteTaskException("Cannot delete completed task.");
        }

        $task->delete();
    }
}
