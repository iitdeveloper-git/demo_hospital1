<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalEquipment extends Model
{
    protected $fillable = [
        'equipment_code',
        'name',
        'manufacturer',
        'calibration_date',
        'status',
    ];
}
