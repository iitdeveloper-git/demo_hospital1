@extends('layouts.inventory', ['title' => 'Purchase Orders Log'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Purchase Orders</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>PO ID</th>
                    <th>Vendor</th>
                    <th>Grand Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $po)
                    <tr>
                        <td><code>{{ $po->po_number }}</code></td>
                        <td><strong>{{ $po->vendor->company_name }}</strong></td>
                        <td>${{ number_format($po->total_amount, 2) }}</td>
                        <td><span class="status-pill status-{{ $po->status }}">{{ ucfirst($po->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No purchase orders registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
