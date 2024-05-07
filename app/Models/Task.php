<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'parent_id',
        'created_at',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
    ];

    public const ALLOWED_SORT_BY = [
        'created_at',
        'completed_at',
        'priority',
    ];

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::COMPLETE;
    }

    public function scopeStatus(Builder $query, $status): void
    {
        if (!empty($status)) {
            $query->where('status', $status);
        }
    }

    public function scopePriority(Builder $query, ?int $priority): void
    {
        if (!empty($priority)) {
            $query->where('priority', $priority);
        }
    }

    public function scopeTextSearch(Builder $query, ?string $text): void
    {
        if (!empty($text)) {
            $query->where(function ($query) use ($text) {
                $query->where('title', 'like', '%' . $text . '%')
                    ->orWhere('description', 'like', '%' . $text . '%');
            });
        }
    }
}
