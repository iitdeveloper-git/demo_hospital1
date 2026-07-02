<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleCollection extends Model
{
    protected $fillable = [
        'lab_order_id',
        'sample_id',
        'sample_type',
        'collection_date',
        'technician_id',
        'notes',
        'status',
    ];

    public function labOrder(): BelongsTo
    {
        return $this->belongsTo(LabOrder::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
