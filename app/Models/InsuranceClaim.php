<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InsuranceClaim extends Model
{
    protected $fillable = [
        'invoice_header_id',
        'company_id',
        'policy_number',
        'claim_amount',
        'approved_amount',
        'status',
    ];

    public function invoiceHeader(): BelongsTo
    {
        return $this->belongsTo(InvoiceHeader::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(InsuranceCompany::class, 'company_id');
    }
}
