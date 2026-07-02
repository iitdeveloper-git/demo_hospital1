<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyAlert extends Model
{
    protected $fillable = [
        'title',
        'type', // Code Blue, Staff Recall
        'status', // active, resolved
    ];
}
