<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialRequestApproval extends Model
{
    protected $fillable = [
        'material_request_id',
        'approved_by',
        'approval_level',
        'decision',
        'reason',
        'decided_at',
    ];

    protected $casts = [
        'decided_at' => 'datetime',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(MaterialRequest::class, 'material_request_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function getDecisionColorAttribute(): string
    {
        return $this->decision === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }
}
