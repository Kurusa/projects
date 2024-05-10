<?php

namespace App\Services;

use App\DTO\TaskData;
use App\Enums\TaskStatus;
use App\Exceptions\CannotCompleteTaskException;
use App\Exceptions\CannotDeleteTaskException;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Spatie\LaravelData\DataCollection;

class TaskService
{
    private TaskRepository $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function search(User $user, array $filters): DataCollection
    {
        $tasks = $this->repository->search($user, $filters);

        return TaskData::collection($tasks->map(fn(Task $task) => TaskData::fromModel($task)));
    }

    public function store(User $user, TaskData $data): TaskData
    {
        $task = $user->tasks()->create($data->all());

        return TaskData::fromModel($task);
    }

    public function complete(Task $task): TaskData
    {
        if ($task->subtasks()->whereIn('status', [TaskStatus::TODO, TaskStatus::IN_PROGRESS])->exists()) {
            throw new CannotCompleteTaskException('All subtasks must be completed before marking this task as completed.');
        }

        $task->update([
            'status' => TaskStatus::COMPLETE,
            'completed_at' => now(),
        ]);

        return TaskData::fromModel($task);
    }

    public function update(Task $task, TaskData $data): TaskData
    {
        $task->update($data->all());

        return TaskData::fromModel($task);
    }

    public function delete(Task $task): void
    {
        if ($task->isCompleted()) {
            throw new CannotDeleteTaskException("Cannot delete completed task.");
        }

        $task->delete();
    }
}
