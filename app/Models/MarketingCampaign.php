<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingCampaign extends Model
{
    protected $fillable = [
        'name',
        'channel',
        'status',
        'schedule_at',
        'template_content',
    ];

    protected $casts = [
        'schedule_at' => 'datetime',
    ];
}
