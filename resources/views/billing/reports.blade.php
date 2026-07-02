@extends('layouts.billing', ['title' => 'Revenue Reports'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Collections & Tax Reports</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Payment Ref</th>
                    <th>Invoice ID</th>
                    <th>Subtotal Amount</th>
                    <th>GST Tax (18%)</th>
                    <th>Grand Total Paid</th>
                    <th>Payment Mode</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                    <tr>
                        <td><code>{{ $pay->transaction_reference }}</code></td>
                        <td><code>{{ $pay->invoiceHeader->invoice_number }}</code></td>
                        <td>${{ number_format($pay->amount / 1.18, 2) }}</td>
                        <td>${{ number_format($pay->amount - ($pay->amount / 1.18), 2) }}</td>
                        <td><strong>${{ number_format($pay->amount, 2) }}</strong></td>
                        <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $pay->payment_method }}</span></td>
                        <td>{{ $pay->created_at->format('M d, Y - H:i') }}</td>
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
