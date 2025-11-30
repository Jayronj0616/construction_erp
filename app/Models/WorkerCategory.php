<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkerCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class, 'category_id');
    }
}
