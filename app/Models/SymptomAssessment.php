<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SymptomAssessment extends Model
{
    protected $fillable = [
        'patient_id',
        'symptoms',
        'duration_days',
        'severity',
        'age',
        'gender',
        'medical_history',
        'possible_conditions',
        'urgency_level',
        'suggested_department',
        'suggested_specialist',
    ];

    protected $casts = [
        'duration_days' => 'integer',
        'age' => 'integer',
        'possible_conditions' => 'json',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
