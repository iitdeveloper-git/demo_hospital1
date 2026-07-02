<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RadiologyAiAnalysis extends Model
{
    protected $table = 'radiology_ai_analysis';

    protected $fillable = [
        'medical_report_id',
        'status',
        'findings_placeholder',
        'recommended_followup',
    ];

    public function medicalReport(): BelongsTo
    {
        return $this->belongsTo(MedicalReport::class);
    }
}
