<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HospitalWard extends Model
{
    protected $fillable = [
        'name',
        'department_name',
        'capacity',
    ];

    public function beds(): HasMany
    {
        return $this->hasMany(HospitalBed::class, 'ward_id');
    }
}
