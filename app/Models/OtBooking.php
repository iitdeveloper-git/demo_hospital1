<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtBooking extends Model
{
    protected $fillable = [
        'emergency_case_id',
        'surgeon_id', // doctor_id reference
        'ot_number',
        'estimated_duration',
        'status', // scheduled, running, completed
    ];

    public function emergencyCase(): BelongsTo
    {
        return $this->belongsTo(EmergencyCase::class);
    }

    public function surgeon(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'surgeon_id');
    }
}
