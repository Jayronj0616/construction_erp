<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerEmergencyContact extends Model
{
    protected $fillable = [
        'worker_id',
        'contact_name',
        'relationship',
        'phone',
        'email',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
