<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiProviderSetting extends Model
{
    protected $fillable = [
        'provider',
        'model',
        'temperature',
        'token_limit',
        'system_prompt',
        'rate_limit',
        'fallback_strategy',
        'is_active',
    ];

    protected $casts = [
        'temperature' => 'float',
        'token_limit' => 'integer',
        'rate_limit' => 'integer',
        'is_active' => 'boolean',
    ];
}
