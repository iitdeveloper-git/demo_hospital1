<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterModeLog extends Model
{
    protected $fillable = [
        'description',
        'staff_recalled_count',
        'status', // active, resolved
    ];
}
