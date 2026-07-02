@extends('layouts.billing', ['title' => 'Double Entry Journal Ledger'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Double Entry Accounting Journal</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Entry ID</th>
                    <th>Ledger Account</th>
                    <th>Debit ($)</th>
                    <th>Credit ($)</th>
                    <th>Description</th>
                    <th>Date Posted</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                    <tr>
                        <td>#JE-{{ str_pad((string)$entry->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $entry->ledgerAccount->name }} ({{ $entry->ledgerAccount->code }})</strong></td>
                        <td style="color:#10b981; font-weight:700;">{{ $entry->debit_amount > 0 ? '$' . number_format($entry->debit_amount, 2) : '-' }}</td>
                        <td style="color:#ef4444; font-weight:700;">{{ $entry->credit_amount > 0 ? '$' . number_format($entry->credit_amount, 2) : '-' }}</td>
                        <td style="font-size:13px; color:var(--text-muted);">{{ $entry->description }}</td>
                        <td>{{ $entry->created_at->format('M d, Y - H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No journal transactions posted.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $entries->links() }}
    </div>
</div>
@endsection
