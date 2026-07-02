<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForecastModel extends Model
{
    protected $fillable = [
        'model_type',
        'variables_json',
        'forecast_outputs_json',
    ];

    protected $casts = [
        'variables_json' => 'json',
        'forecast_outputs_json' => 'json',
    ];
}
