<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerApplication extends Model
{
    protected $fillable = [
        'job_id',
        'name',
        'email',
        'resume_path',
        'status',
    ];

    public function job(): BelongsTo
    {
        return $this->belongsTo(CareerJob::class, 'job_id');
    }
}
