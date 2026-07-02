<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalBed extends Model
{
    protected $fillable = [
        'bed_number',
        'ward_id',
        'status', // available, occupied, reserved, cleaning, maintenance
    ];

    public function ward(): BelongsTo
    {
        return $this->belongsTo(HospitalWard::class);
    }
}
