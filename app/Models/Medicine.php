<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medicine extends Model
{
    protected $fillable = [
        'medicine_code',
        'barcode',
        'name',
        'generic_name',
        'brand_id',
        'category_id',
        'strength',
        'dosage_form',
        'pack_size',
        'purchase_price',
        'selling_price',
        'mrp',
        'stock',
        'reorder_level',
        'manufacturer',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'purchase_price' => 'decimal:2',
            'selling_price' => 'decimal:2',
            'mrp' => 'decimal:2',
            'expires_at' => 'date',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(MedicineCategory::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(MedicineBrand::class, 'brand_id');
    }
}
