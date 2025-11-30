<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkerPosition extends Model
{
    protected $fillable = [
        'name',
        'description',
        'base_daily_rate',
    ];

    protected $casts = [
        'base_daily_rate' => 'decimal:2',
    ];

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class, 'position_id');
    }
}
