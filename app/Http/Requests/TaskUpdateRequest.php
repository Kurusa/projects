<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TaskUpdateRequest",
 *     type="object",
 *     title="Task Update Request",
 *     description="Request for updating an existing task",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Updated Task Title",
 *         nullable=true,
 *         description="New title of the task"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Updated task description",
 *         nullable=true,
 *         description="New description of the task"
 *     ),
 *     @OA\Property(
 *         property="priority",
 *         type="integer",
 *         example=4,
 *         nullable=true,
 *         minimum=1,
 *         maximum=5,
 *         description="New priority level of the task"
 *     ),
 *     @OA\Property(
 *         property="parent_id",
 *         type="integer",
 *         example=2,
 *         nullable=true,
 *         description="New parent task ID if changed"
 *     )
 * )
 */
class TaskUpdateRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string', 'max:1000'],
            'priority' => ['sometimes', 'integer', 'min:1', 'max:5'],
            'parent_id' => ['sometimes', 'integer', 'exists:tasks,id'],
        ];
    }
}
