<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TriageAssessment extends Model
{
    protected $fillable = [
        'emergency_case_id',
        'heart_rate',
        'blood_pressure',
        'temperature',
        'oxygen_saturation',
        'pain_scale',
        'status', // red, orange, yellow, green, black
    ];

    public function emergencyCase(): BelongsTo
    {
        return $this->belongsTo(EmergencyCase::class);
    }
}
