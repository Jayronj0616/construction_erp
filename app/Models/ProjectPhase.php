<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPhase extends Model
{
    protected $fillable = [
        'project_id',
        'phase_name',
        'start_date',
        'end_date',
        'status',
        'progress',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Planning' => 'bg-gray-100 text-gray-800',
            'Active' => 'bg-blue-100 text-blue-800',
            'On-Hold' => 'bg-yellow-100 text-yellow-800',
            'Completed' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
