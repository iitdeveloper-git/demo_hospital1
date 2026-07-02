<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'invoice_header_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'status',
    ];

    public function invoiceHeader(): BelongsTo
    {
        return $this->belongsTo(InvoiceHeader::class);
    }
}
