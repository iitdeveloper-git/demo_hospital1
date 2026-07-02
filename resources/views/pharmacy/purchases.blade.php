@extends('layouts.pharmacy', ['title' => 'Purchase Orders'])

@section('content')
<div class="purchases-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Record Supplier Purchase</h2>
            </div>
            
            <form action="{{ route('pharmacy.purchases.store') }}" method="POST" class="purchase-form">
                @csrf
                
                <div class="form-group">
                    <label for="supplier_id">Supplier Company</label>
                    <select id="supplier_id" name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="total_amount">Total Invoice Amount ($)</label>
                    <input type="number" id="total_amount" name="total_amount" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-truck-loading"></i> Complete Stock Check-In</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Purchase Orders Log</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>PO ID</th>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $po)
                            <tr>
                                <td><code>{{ $po->po_number }}</code></td>
                                <td><strong>{{ $po->supplier->company_name }}</strong></td>
                                <td>${{ number_format($po->total_amount, 2) }}</td>
                                <td><span class="status-pill status-{{ $po->status }}">{{ ucfirst($po->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No purchase orders logged.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $orders->links() }}
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

    .purchase-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .purchase-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .purchase-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .purchase-form select,
    .purchase-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .purchase-form select:focus,
    .purchase-form input:focus {
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
