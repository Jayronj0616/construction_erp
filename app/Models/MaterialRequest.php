<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialRequest extends Model
{
    protected $fillable = [
        'project_id',
        'requested_by',
        'status',
        'date_needed',
        'purpose',
        'rejection_reason',
    ];

    protected $casts = [
        'date_needed' => 'date',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MaterialRequestItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(MaterialRequestApproval::class);
    }

    public function issuance(): BelongsTo
    {
        return $this->hasOne(MaterialIssuance::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'Pending' => 'bg-gray-100 text-gray-800',
            'Supervisor Approved' => 'bg-blue-100 text-blue-800',
            'Manager Approved' => 'bg-cyan-100 text-cyan-800',
            'Partially Issued' => 'bg-yellow-100 text-yellow-800',
            'Issued' => 'bg-green-100 text-green-800',
            'Rejected' => 'bg-red-100 text-red-800',
            'Cancelled' => 'bg-gray-200 text-gray-700',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function canBeSupervisorApproved(): bool
    {
        return $this->status === 'Pending';
    }

    public function canBeManagerApproved(): bool
    {
        return $this->status === 'Supervisor Approved';
    }

    public function canBeIssued(): bool
    {
        return $this->status === 'Manager Approved';
    }

    public function canBeRejected(): bool
    {
        return in_array($this->status, ['Pending', 'Supervisor Approved', 'Manager Approved']);
    }

    public function getTotalRequestedAttribute(): int
    {
        return $this->items->sum('quantity_requested');
    }

    public function getTotalIssuedAttribute(): int
    {
        return $this->items->sum('quantity_issued');
    }

    public function isFullyIssued(): bool
    {
        return $this->total_requested === $this->total_issued;
    }

    public function isPartiallyIssued(): bool
    {
        return $this->total_issued > 0 && !$this->isFullyIssued();
    }
}
