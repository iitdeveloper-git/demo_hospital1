<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'oxygen_level',
        'blood_sugar',
        'weight',
        'height',
        'bmi',
        'medical_notes',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'heart_rate' => 'integer',
            'temperature' => 'decimal:1',
            'oxygen_level' => 'integer',
            'blood_sugar' => 'integer',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
            'bmi' => 'decimal:2',
            'recorded_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
