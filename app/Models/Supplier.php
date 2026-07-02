<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_code',
        'company_name',
        'gst_number',
        'contact_person',
        'phone',
        'email',
        'address',
        'outstanding_balance',
    ];
}
