<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_header_id',
        'item_name',
        'quantity',
        'price',
        'subtotal',
    ];

    public function invoiceHeader(): BelongsTo
    {
        return $this->belongsTo(InvoiceHeader::class);
    }
}
