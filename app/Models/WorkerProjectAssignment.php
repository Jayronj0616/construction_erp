<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerProjectAssignment extends Model
{
    protected $fillable = [
        'worker_id',
        'project_id',
        'start_date',
        'end_date',
        'status',
        'assignment_role',
        'daily_rate',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_rate' => 'decimal:2',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Active' => 'bg-green-100 text-green-800',
            'Completed' => 'bg-blue-100 text-blue-800',
            'On-Hold' => 'bg-yellow-100 text-yellow-800',
            'Terminated' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getDurationDaysAttribute(): int
    {
        $endDate = $this->end_date ?? now();
        return $this->start_date->diffInDays($endDate);
    }

    public function isActive(): bool
    {
        return $this->status === 'Active' && $this->start_date->isPast();
    }
}
