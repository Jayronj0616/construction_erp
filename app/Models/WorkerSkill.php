<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerSkill extends Model
{
    protected $fillable = [
        'worker_id',
        'skill_name',
        'proficiency',
        'certification_expiry',
        'certification_file',
    ];

    protected $casts = [
        'certification_expiry' => 'date',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function isExpired(): bool
    {
        return $this->certification_expiry && $this->certification_expiry->isPast();
    }

    public function isExpiring(): bool
    {
        return $this->certification_expiry 
            && $this->certification_expiry->isBetween(now(), now()->addMonths(1));
    }

    public function getStatusColorAttribute(): string
    {
        if (!$this->certification_expiry) {
            return 'bg-gray-100 text-gray-800';
        }

        if ($this->isExpired()) {
            return 'bg-red-100 text-red-800';
        }

        if ($this->isExpiring()) {
            return 'bg-yellow-100 text-yellow-800';
        }

        return 'bg-green-100 text-green-800';
    }
}
