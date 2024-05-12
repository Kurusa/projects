<?php

namespace App\Data;

use App\Enums\TaskStatus;
use App\Models\Task;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * @OA\Schema(
 *     schema="TaskData",
 *     type="object",
 *     title="Task Data",
 *     description="Data representing a task",
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
 *             @OA\Items(ref="#/components/schemas/TaskData"),
 *             description="List of subtasks"
 *         ),
 *     }
 * )
 */
class TaskData extends Data
{
    public function __construct(
        public int              $id,
        public string           $title,
        public ?string          $description,
        public TaskStatus       $status,
        public int              $priority,
        public ?int             $parent_id,
        public ?CarbonImmutable $created_at,
        public ?CarbonImmutable $updated_at,
        public ?CarbonImmutable $completed_at,
        #[DataCollectionOf(TaskData::class)]
        public ?DataCollection  $subtasks
    )
    {
    }

    public static function fromModel(Task $task): self
    {
        return new self(
            $task->id,
            $task->title,
            $task->description,
            $task->status,
            $task->priority,
            $task->parent_id,
            $task->created_at ? CarbonImmutable::parse($task->created_at) : null,
            $task->updated_at ? CarbonImmutable::parse($task->updated_at) : null,
            $task->completed_at ? CarbonImmutable::parse($task->completed_at) : null,
            TaskData::collection($task->subtasks)
        );
    }

    public static function collection($tasks): DataCollection
    {
        return new DataCollection(TaskData::class, $tasks);
    }
}
