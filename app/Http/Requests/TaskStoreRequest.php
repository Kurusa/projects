<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TaskStoreRequest",
 *     type="object",
 *     title="Task Store Request",
 *     description="Request for creating a new task",
 *     required={"title", "priority"},
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="New Task",
 *         description="Title of the task"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Detailed description of the task",
 *         nullable=true,
 *         description="Description of the task"
 *     ),
 *     @OA\Property(
 *         property="priority",
 *         type="integer",
 *         example=3,
 *         minimum=1,
 *         maximum=5,
 *         description="Priority level of the task"
 *     ),
 *     @OA\Property(
 *         property="parent_id",
 *         type="integer",
 *         example=1,
 *         nullable=true,
 *         description="Parent task ID for hierarchical relationship"
 *     )
 * )
 */
class TaskStoreRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'priority' => ['required', 'integer', 'min:1', 'max:5'],
            'parent_id' => ['nullable', 'integer', 'exists:tasks,id'],
        ];
    }
}
