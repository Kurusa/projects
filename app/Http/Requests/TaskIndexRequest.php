<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @OA\Schema(
 *     schema="TaskIndexRequest",
 *     type="object",
 *     title="Task Index Request",
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         enum={"TODO", "IN_PROGRESS", "COMPLETE"},
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="priority",
 *         type="integer",
 *         example=3,
 *         minimum=1,
 *         maximum=5,
 *         nullable=true,
 *     ),
 *     @OA\Property(
 *         property="text",
 *         type="string",
 *         example="Sample text",
 *         nullable=true,
 *         description="Search text to filter tasks"
 *     ),
 *     @OA\Property(
 *         property="sortBy",
 *         type="string",
 *         example="created_at",
 *         description="Field to sort the tasks"
 *     ),
 *     @OA\Property(
 *         property="sortDirection",
 *         type="string",
 *         enum={"asc", "desc"},
 *         example="asc",
 *         description="Direction of the sort"
 *     ),
 * )
 */
class TaskIndexRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', new Enum(TaskStatus::class)],
            'priority' => ['nullable', 'integer', 'min:1', 'max:5'],
            'text' => ['nullable', 'string', 'max:255'],
            'sortBy' => ['nullable', 'in:' . implode(',', Task::ALLOWED_SORT_BY)],
            'sortDirection' => ['nullable', 'in:asc,desc'],
        ];
    }
}
