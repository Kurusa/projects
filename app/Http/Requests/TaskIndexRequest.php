<?php

namespace App\Http\Requests;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
