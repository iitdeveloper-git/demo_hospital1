<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalAlert extends Model
{
    protected $fillable = [
        'patient_id',
        'alert_type',
        'severity',
        'message',
        'is_resolved',
        'resolved_by',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function resolvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
