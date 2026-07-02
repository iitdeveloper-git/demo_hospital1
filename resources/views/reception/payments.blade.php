@extends('layouts.reception', ['title' => 'Invoices Log'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Outpatient Billing & Payments Collection</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Patient Name</th>
                    <th>Subtotal</th>
                    <th>Tax (GST)</th>
                    <th>Grand Total</th>
                    <th>Payment Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bills as $bill)
                    <tr>
                        <td><code>INV-{{ str_pad((string)$bill->id, 5, '0', STR_PAD_LEFT) }}</code></td>
                        <td><strong>{{ $bill->patient->user->name }}</strong></td>
                        <td>${{ number_format($bill->amount, 2) }}</td>
                        <td>${{ number_format($bill->tax, 2) }}</td>
                        <td><strong>${{ number_format($bill->total, 2) }}</strong></td>
                        <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $bill->payment_method }}</span></td>
                        <td><span class="status-pill status-{{ $bill->status }}">{{ ucfirst($bill->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No payment receipts issued today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $bills->links() }}
    </div>
</div>
@endsection
