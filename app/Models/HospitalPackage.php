<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
}
