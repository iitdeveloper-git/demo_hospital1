@extends('layouts.inventory', ['title' => 'Goods Receipt'])

@section('content')
<div class="receipt-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Record Goods Receipt</h2>
            </div>
            
            <form action="{{ route('inventory.goods-receipt.store') }}" method="POST" class="receipt-form">
                @csrf
                
                <div class="form-group">
                    <label for="purchase_order_id">Pending Purchase Orders</label>
                    <select id="purchase_order_id" name="purchase_order_id" required>
                        <option value="">Select Purchase Order</option>
                        @foreach($orders as $po)
                            <option value="{{ $po->id }}">{{ $po->po_number }} - {{ $po->vendor->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-file-invoice"></i> Log Goods Check-In</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Goods Receipts Historical Logs</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Receipt ID</th>
                            <th>PO Ref</th>
                            <th>Vendor</th>
                            <th>Received Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($receipts as $receipt)
                            <tr>
                                <td>GR-{{ str_pad((string)$receipt->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td><code>{{ $receipt->purchaseOrder->po_number }}</code></td>
                                <td><strong>{{ $receipt->purchaseOrder->vendor->company_name }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($receipt->received_date)->format('M d, Y') }}</td>
                                <td><span class="status-pill status-{{ $receipt->status }}">{{ ucfirst($receipt->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No goods receipt checks completed today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $receipts->links() }}
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

    .receipt-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .receipt-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .receipt-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .receipt-form select {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .receipt-form select:focus {
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
