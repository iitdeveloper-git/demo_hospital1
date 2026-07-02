<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmergencyCase extends Model
{
    protected $fillable = [
        'case_number',
        'patient_id',
        'arrival_method', // Walk-in, Ambulance
        'priority_level', // Red, Orange, Yellow, Green, Black
        'status', // triage, icu, ot, discharged
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function triage(): HasOne
    {
        return $this->hasOne(TriageAssessment::class);
    }
}
