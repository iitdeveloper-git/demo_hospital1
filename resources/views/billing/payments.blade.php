@extends('layouts.billing', ['title' => 'POS Payments Cashier'])

@section('content')
<div class="payments-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>POS Cashier Terminal</h2>
            </div>
            
            <form action="{{ route('billing.payments.store') }}" method="POST" class="payment-form">
                @csrf
                
                <div class="form-group">
                    <label for="invoice_header_id">Pending Invoices</label>
                    <select id="invoice_header_id" name="invoice_header_id" required>
                        <option value="">Select Invoice</option>
                        @foreach($invoices as $inv)
                            <option value="{{ $inv->id }}">{{ $inv->invoice_number }} - {{ $inv->patient->user->name }} (${{ number_format($inv->grand_total, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="amount">Payment Amount ($)</label>
                    <input type="number" id="amount" name="amount" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Mode</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="cash">Cash Payment</option>
                        <option value="card">Card / POS Terminal</option>
                        <option value="upi">UPI / Dynamic QR Scan</option>
                        <option value="wallet">Patient wallet balance</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cash-register"></i> Complete Checkout</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Billing Payments Transactions Log</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Transaction Ref</th>
                            <th>Invoice ID</th>
                            <th>Customer</th>
                            <th>Paid Amount</th>
                            <th>Payment Method</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $pay)
                            <tr>
                                <td><code>{{ $pay->transaction_reference }}</code></td>
                                <td><code>{{ $pay->invoiceHeader->invoice_number }}</code></td>
                                <td><strong>{{ $pay->invoiceHeader->patient->user->name }}</strong></td>
                                <td><strong>${{ number_format($pay->amount, 2) }}</strong></td>
                                <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $pay->payment_method }}</span></td>
                                <td>{{ $pay->created_at->format('M d, Y - H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No payment cashier checkouts recorded today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $payments->links() }}
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

    .payment-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .payment-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .payment-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .payment-form select,
    .payment-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .payment-form select:focus,
    .payment-form input:focus {
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
