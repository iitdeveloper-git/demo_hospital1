@extends('layouts.pharmacy', ['title' => 'Sales Reports Ledger'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Pharmacy Sales & Tax Ledger Reports</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Customer Name</th>
                    <th>Subtotal Amount</th>
                    <th>GST Tax (18%)</th>
                    <th>Grand Total Amount</th>
                    <th>Payment Method</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td><code>{{ $sale->invoice_number }}</code></td>
                        <td><strong>{{ $sale->patient ? $sale->patient->user->name : 'Walk-in Customer' }}</strong></td>
                        <td>${{ number_format($sale->total_amount / 1.18, 2) }}</td>
                        <td>${{ number_format($sale->tax, 2) }}</td>
                        <td><strong>${{ number_format($sale->total_amount, 2) }}</strong></td>
                        <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $sale->payment_method }}</span></td>
                        <td>{{ $sale->created_at->format('M d, Y - H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No transaction logs recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
