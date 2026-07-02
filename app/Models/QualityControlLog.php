<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QualityControlLog extends Model
{
    protected $fillable = [
        'equipment_id',
        'qc_name',
        'result',
        'status',
        'checked_at',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(LabEquipment::class, 'equipment_id');
    }
}
