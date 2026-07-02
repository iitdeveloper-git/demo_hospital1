<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    protected $fillable = [
        'vehicle_number',
        'vehicle_type', // BLS, ALS
        'availability',
        'status', // operational, out-of-service
    ];
}
