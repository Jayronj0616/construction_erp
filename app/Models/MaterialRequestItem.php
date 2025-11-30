<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialRequestItem extends Model
{
    protected $fillable = [
        'material_request_id',
        'material_id',
        'quantity_requested',
        'quantity_issued',
        'notes',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(MaterialRequest::class, 'material_request_id');
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function getRemainingQuantityAttribute(): int
    {
        return $this->quantity_requested - $this->quantity_issued;
    }

    public function isFullyIssued(): bool
    {
        return $this->quantity_issued === $this->quantity_requested;
    }

    public function isPartiallyIssued(): bool
    {
        return $this->quantity_issued > 0 && !$this->isFullyIssued();
    }

    public function getAvailableStockAttribute(): int
    {
        return $this->material->quantity_in_stock;
    }

    public function hasEnoughStock(): bool
    {
        return $this->available_stock >= $this->remaining_quantity;
    }
}
