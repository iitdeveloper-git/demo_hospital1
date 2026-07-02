<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HospitalAsset extends Model
{
    protected $fillable = [
        'asset_tag',
        'barcode',
        'name',
        'category_id',
        'purchase_date',
        'current_value',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, 'category_id');
    }
}
