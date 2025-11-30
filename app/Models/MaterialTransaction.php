<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialTransaction extends Model
{
    protected $fillable = [
        'material_id',
        'type',
        'quantity',
        'reference_type',
        'reference_id',
        'notes',
        'recorded_by',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'addition' => 'bg-green-100 text-green-800',
            'usage' => 'bg-blue-100 text-blue-800',
            'adjustment' => 'bg-gray-100 text-gray-800',
            'damage' => 'bg-red-100 text-red-800',
            'return' => 'bg-yellow-100 text-yellow-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
