<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsReceipt extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'received_date',
        'status',
    ];

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(InvPurchaseOrder::class, 'purchase_order_id');
    }
}
