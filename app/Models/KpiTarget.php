<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTarget extends Model
{
    protected $fillable = [
        'kpi_name',
        'target_value',
        'current_value',
        'achievement_percentage',
        'category',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'target_value' => 'float',
        'current_value' => 'float',
        'achievement_percentage' => 'float',
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];
}
