<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemMetric extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'cpu_load',
        'memory_load',
        'active_connections',
        'logged_at',
    ];

    protected $casts = [
        'cpu_load' => 'float',
        'memory_load' => 'float',
        'active_connections' => 'integer',
        'logged_at' => 'datetime',
    ];
}
