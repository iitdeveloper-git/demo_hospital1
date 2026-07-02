<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reagent extends Model
{
    protected $fillable = [
        'name',
        'batch_number',
        'expiry_date',
        'stock',
        'low_stock_level',
    ];
}
