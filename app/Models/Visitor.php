<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'patient_name',
        'relationship',
        'mobile',
        'purpose',
        'entry_time',
        'exit_time',
        'pass_number',
    ];
}
