<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LabAiAnalysis extends Model
{
    protected $table = 'lab_ai_analysis';

    protected $fillable = [
        'medical_report_id',
        'abnormal_values',
        'trend_analysis',
        'recommendations',
    ];

    protected $casts = [
        'abnormal_values' => 'json',
    ];

    public function medicalReport(): BelongsTo
    {
        return $this->belongsTo(MedicalReport::class);
    }
}
