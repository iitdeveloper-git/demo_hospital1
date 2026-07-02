@extends('layouts.billing', ['title' => 'Refunds Desk'])

@section('content')
<div class="refunds-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Authorize Refund Transaction</h2>
            </div>
            
            <form action="{{ route('billing.refunds.store') }}" method="POST" class="refund-form">
                @csrf
                
                <div class="form-group">
                    <label for="payment_id">Complete Cashier Payments</label>
                    <select id="payment_id" name="payment_id" required>
                        <option value="">Select Payment</option>
                        @foreach($payments as $pay)
                            <option value="{{ $pay->id }}">{{ $pay->transaction_reference }} - {{ $pay->invoiceHeader->patient->user->name }} (${{ number_format($pay->amount, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">Refund Amount ($)</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="reason">Reason / Remarks</label>
                    <textarea id="reason" name="reason" rows="3" placeholder="Discharge recalculation or admission cancellation..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-undo"></i> Approve Refund</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Approved Refunds Audit logs</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer</th>
                            <th>Refund Amount</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($refunds as $ref)
                            <tr>
                                <td><code>{{ $ref->payment->invoiceHeader->invoice_number }}</code></td>
                                <td><strong>{{ $ref->payment->invoiceHeader->patient->user->name }}</strong></td>
                                <td><strong style="color:#ef4444;">${{ number_format($ref->amount, 2) }}</strong></td>
                                <td style="font-size:12px; color:var(--text-muted);">{{ $ref->reason }}</td>
                                <td><span class="status-pill status-{{ $ref->status }}">{{ ucfirst($ref->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No refunds logged.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $refunds->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 32px;
        align-items: start;
    }

    .refund-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .refund-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .refund-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .refund-form select,
    .refund-form input,
    .refund-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .refund-form select:focus,
    .refund-form input:focus,
    .refund-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
