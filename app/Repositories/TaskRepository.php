<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function search(User $user, array $filters): Collection
    {
        $query = $user->tasks()->with('subtasks');

        $query->status($filters['status'] ?? null)
            ->priority($filters['priority'] ?? null)
            ->textSearch($filters['text'] ?? null);

        if (isset($filters['sortBy'])) {
            $sorts = explode(',', $filters['sortBy']);

            foreach ($sorts as $sort) {
                $parts = explode(':', $sort);
                $field = $parts[0];
                $direction = $parts[1] ?? 'asc';
                $query->orderBy($field, $direction);
            }
        } else {
            $query->orderBy('created_at');
        }

        return $query->get();
    }
}
