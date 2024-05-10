<?php

namespace App\DTO;

use App\Models\Task;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

/**
 * @OA\Schema(
 *     schema="TaskDTO",
 *     type="object",
 *     title="Task DTO",
 *     description="DTO representing a task",
 *     properties={
 *         @OA\Property(property="id", type="integer", description="ID of the task"),
 *         @OA\Property(property="title", type="string", description="Title of the task"),
 *         @OA\Property(property="description", type="string", description="Description of the task"),
 *         @OA\Property(property="status", type="string", enum={"todo", "in_progress", "complete"}, description="Status of the task"),
 *         @OA\Property(property="priority", type="integer", description="Priority of the task"),
 *         @OA\Property(property="parent_id", type="integer", description="ID of the parent task, if any"),
 *         @OA\Property(property="created_at", type="string", format="date-time", description="Creation timestamp"),
 *         @OA\Property(property="updated_at", type="string", format="date-time", description="Update timestamp"),
 *         @OA\Property(property="completed_at", type="string", format="date-time", description="Completion timestamp"),
 *         @OA\Property(
 *             property="subtasks",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/TaskDTO"),
 *             description="List of subtasks"
 *         ),
 *     }
 * )
 */
class TaskDTO extends Data
{
    public int $id;
    public string $title;
    public ?string $description;
    public string $status;
    public int $priority;
    public ?int $parent_id;
    public ?string $created_at;
    public ?string $updated_at;
    public ?string $completed_at;

    /** @var DataCollection<int, self> */
    public DataCollection $subtasks;

    public static function fromModel(Task $task): self
    {
        return new self(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: $task->status,
            priority: $task->priority,
            parent_id: $task->parent_id,
            created_at: $task->created_at?->toDateTimeString(),
            updated_at: $task->updated_at?->toDateTimeString(),
            completed_at: $task->completed_at?->toDateTimeString(),
            subtasks: self::collection($task->subtasks->map(fn($subtask) => self::fromModel($subtask))->all())
        );
    }
}
