<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsSnapshot extends Model
{
    protected $fillable = [
        'branch_id',
        'snapshot_date',
        'category',
        'metrics_json',
    ];

    protected $casts = [
        'snapshot_date' => 'date',
        'metrics_json' => 'json',
    ];
}
