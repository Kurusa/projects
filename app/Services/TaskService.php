<?php

namespace App\Services;

use App\Data\TaskData;
use App\Enums\TaskStatus;
use App\Exceptions\CannotCompleteTaskException;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Spatie\LaravelData\DataCollection;

readonly class TaskService
{
    public function __construct(public TaskRepository $repository)
    {
    }

    public function search(User $user, array $filters): DataCollection
    {
        $tasks = $this->repository->search($user, $filters);

        return TaskData::collection($tasks);
    }

    public function store(User $user, TaskData $data): TaskData
    {
        $task = $user->tasks()->create($data->only(
            'title',
            'description',
            'status',
            'priority',
            'parent_id',
            'completed_at',
        )->toArray());

        return TaskData::from($task);
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
        $task->delete();
    }
}
