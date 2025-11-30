<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'description',
        'category_id',
        'unit_of_measure',
        'quantity_in_stock',
        'reorder_level',
        'unit_price',
        'image_path',
        'notes',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterialCategory::class, 'category_id');
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(MaterialSupplier::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MaterialTransaction::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity_in_stock <= $this->reorder_level;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity_in_stock == 0) {
            return 'Out of Stock';
        }
        if ($this->isLowStock()) {
            return 'Low Stock';
        }
        return 'In Stock';
    }

    public function getStockStatusColorAttribute(): string
    {
        return match($this->stock_status) {
            'Out of Stock' => 'bg-red-100 text-red-800',
            'Low Stock' => 'bg-yellow-100 text-yellow-800',
            'In Stock' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getTotalInventoryValueAttribute(): float
    {
        return $this->quantity_in_stock * $this->unit_price;
    }
}
