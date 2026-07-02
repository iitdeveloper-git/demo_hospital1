@extends('layouts.patient', ['title' => 'Invoices & Payments'])

@section('content')
<div class="payments-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Billing & Accounts Statement</h2>
        </div>

        <div class="table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Discount</th>
                        <th>Total Due</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        @php($total = $bill->amount + $bill->tax - $bill->discount)
                        <tr>
                            <td><strong>{{ $bill->invoice_number }}</strong></td>
                            <td>${{ number_format($bill->amount, 2) }}</td>
                            <td>${{ number_format($bill->tax, 2) }}</td>
                            <td>${{ number_format($bill->discount, 2) }}</td>
                            <td><strong>${{ number_format($total, 2) }}</strong></td>
                            <td><span class="status-pill status-{{ $bill->status }}">{{ ucfirst($bill->status) }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($bill->due_at)->format('M d, Y') }}</td>
                            <td>
                                @if($bill->status === 'pending' || $bill->status === 'overdue')
                                    <button class="btn btn-primary btn-sm" onclick="alert('Redirecting to Stripe sandbox interface for: {{ $bill->invoice_number }}\n\nAmount: ${{ number_format($total, 2) }}')">
                                        <i class="fa-solid fa-credit-card"></i> Pay Now
                                    </button>
                                @else
                                    <button class="btn btn-secondary btn-sm" onclick="alert('Downloading invoice statement PDF for: {{ $bill->invoice_number }}')">
                                        <i class="fa-solid fa-file-pdf"></i> Receipt
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">No billing invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $bills->links() }}
        </div>
    </div>
</div>

<style>
    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }
</style>
@endsection
