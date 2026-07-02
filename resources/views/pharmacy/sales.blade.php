@extends('layouts.pharmacy', ['title' => 'POS Billing Cashier'])

@section('content')
<div class="sales-wrap">
    <div class="split-layout">
        <!-- Left: Walk-in POS Billing Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>POS Cashier Terminal</h2>
            </div>
            
            <form action="{{ route('pharmacy.sales.store') }}" method="POST" class="pos-billing-form">
                @csrf
                
                <div class="form-group">
                    <label for="patient_id">Outpatient (Optional)</label>
                    <select id="patient_id" name="patient_id">
                        <option value="">Walk-in Customer</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="medicine_id">Medicine Item</label>
                    <select id="medicine_id" name="medicine_id" required>
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $med)
                            <option value="{{ $med->id }}">{{ $med->name }} (In Stock: {{ $med->stock }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Mode</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="cash">Cash Payment</option>
                        <option value="card">Card / POS Terminal</option>
                        <option value="upi">UPI / Dynamic QR Scan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cart-shopping"></i> Complete POS Checkout</button>
            </form>
        </div>

        <!-- Right: Sales Transactions Log -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Billing Invoices Log</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>GST Tax</th>
                            <th>Payment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td><code>{{ $sale->invoice_number }}</code></td>
                                <td><strong>{{ $sale->patient ? $sale->patient->user->name : 'Walk-in Customer' }}</strong></td>
                                <td>${{ number_format($sale->total_amount, 2) }}</td>
                                <td>${{ number_format($sale->tax, 2) }}</td>
                                <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $sale->payment_method }}</span></td>
                                <td><span class="status-pill status-{{ $sale->status }}">{{ ucfirst($sale->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No transactions checked out today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $sales->links() }}
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

    .pos-billing-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .pos-billing-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .pos-billing-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .pos-billing-form select,
    .pos-billing-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .pos-billing-form select:focus,
    .pos-billing-form input:focus {
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
