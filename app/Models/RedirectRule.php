<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedirectRule extends Model
{
    protected $fillable = [
        'old_slug',
        'new_slug',
        'status_code',
    ];

    protected $casts = [
        'status_code' => 'integer',
    ];
}
