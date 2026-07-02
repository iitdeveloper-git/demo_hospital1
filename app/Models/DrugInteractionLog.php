<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugInteractionLog extends Model
{
    protected $fillable = [
        'patient_id',
        'drug_a',
        'drug_b',
        'severity',
        'interaction_description',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
