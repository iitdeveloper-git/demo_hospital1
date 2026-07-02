<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientRiskScore extends Model
{
    protected $fillable = [
        'patient_id',
        'risk_type',
        'score',
        'trend_direction',
        'assessment_date',
    ];

    protected $casts = [
        'score' => 'float',
        'assessment_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
