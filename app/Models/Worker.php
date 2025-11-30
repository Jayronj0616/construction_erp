<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{
    protected $fillable = [
        'worker_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'position_id',
        'category_id',
        'hire_date',
        'status',
        'profile_image',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(WorkerPosition::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(WorkerCategory::class);
    }

    public function emergencyContact(): HasMany
    {
        return $this->hasMany(WorkerEmergencyContact::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(WorkerSkill::class);
    }

    public function projectAssignments(): HasMany
    {
        return $this->hasMany(WorkerProjectAssignment::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Active' => 'bg-green-100 text-green-800',
            'On-Leave' => 'bg-yellow-100 text-yellow-800',
            'Transferred' => 'bg-blue-100 text-blue-800',
            'Terminated' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getYearsOfServiceAttribute(): int
    {
        return $this->hire_date->diffInYears(now());
    }

    public function getCurrentProjectCount(): int
    {
        return $this->projectAssignments()
            ->where('status', 'Active')
            ->count();
    }

    public function expiringCertifications()
    {
        return $this->skills()
            ->where('certification_expiry', '<=', now()->addMonths(1))
            ->where('certification_expiry', '>', now())
            ->get();
    }

    public function expiredCertifications()
    {
        return $this->skills()
            ->where('certification_expiry', '<=', now())
            ->get();
    }
}
