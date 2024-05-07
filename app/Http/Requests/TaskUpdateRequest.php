<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{
    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'priority' => 'sometimes|integer|min:1|max:5',
            'parent_id' => 'sometimes|integer|exists:tasks,id',
        ];
    }
}
