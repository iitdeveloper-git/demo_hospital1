<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'branch_id',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(HospitalBranch::class);
    }
}
