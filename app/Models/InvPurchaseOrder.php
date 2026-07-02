<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvPurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'vendor_id',
        'status',
        'total_amount',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvPurchaseItem::class, 'purchase_order_id');
    }
}
