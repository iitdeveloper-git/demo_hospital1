@extends('layouts.billing', ['title' => 'Ledger Accounts Balances'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Ledger General Accounts</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Account Code</th>
                    <th>Account Name</th>
                    <th>Category Type</th>
                    <th>Debit Balance ($)</th>
                    <th>Credit Balance ($)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $acc)
                    <tr>
                        <td><code>{{ $acc->code }}</code></td>
                        <td><strong>{{ $acc->name }}</strong></td>
                        <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $acc->type }}</span></td>
                        <td style="color:#10b981; font-weight:700;">
                            ${{ number_format($acc->journalEntries->sum('debit_amount'), 2) }}
                        </td>
                        <td style="color:#ef4444; font-weight:700;">
                            ${{ number_format($acc->journalEntries->sum('credit_amount'), 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No ledger accounts registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $accounts->links() }}
    </div>
</div>
@endsection
