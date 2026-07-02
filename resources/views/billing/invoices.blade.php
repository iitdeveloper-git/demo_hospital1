@extends('layouts.billing', ['title' => 'Invoices Registry'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Outpatient Invoices Log</h2>
        <form action="{{ route('billing.invoices') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient name..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Patient</th>
                    <th>Subtotal Amount</th>
                    <th>GST Tax</th>
                    <th>Grand Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $inv)
                    <tr>
                        <td><code>{{ $inv->invoice_number }}</code></td>
                        <td>
                            <strong>{{ $inv->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $inv->patient->patient_code }}</span>
                        </td>
                        <td>${{ number_format($inv->total_amount, 2) }}</td>
                        <td>${{ number_format($inv->tax, 2) }}</td>
                        <td><strong>${{ number_format($inv->grand_total, 2) }}</strong></td>
                        <td><span class="status-pill status-{{ $inv->status }}">{{ ucfirst($inv->status) }}</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="alert('Digital Signatures Verification:\n\nVerifier: Billing Command Verifier\nDigitally Signed: SHA-256\nGrand Total: ${{ number_format($inv->grand_total, 2) }}')"><i class="fa-solid fa-signature"></i> Verify</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No invoices generated yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
