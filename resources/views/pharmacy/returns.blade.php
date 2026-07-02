@extends('layouts.pharmacy', ['title' => 'Returns Registry'])

@section('content')
<div class="returns-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Record Damaged/Expired Return</h2>
            </div>
            
            <form action="{{ route('pharmacy.returns.store') }}" method="POST" class="return-form">
                @csrf
                
                <div class="form-group">
                    <label for="medicine_id">Medicine Item</label>
                    <select id="medicine_id" name="medicine_id" required>
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $med)
                            <option value="{{ $med->id }}">{{ $med->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Return Quantity</label>
                    <input type="number" id="quantity" name="quantity" min="1" required>
                </div>

                <div class="form-group">
                    <label for="type">Return Type</label>
                    <select id="type" name="type" required>
                        <option value="customer">Customer Refund Return</option>
                        <option value="supplier">Supplier Damage Return</option>
                        <option value="expired">Expired Waste Return</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reason">Reason / Remarks</label>
                    <textarea id="reason" name="reason" rows="3" placeholder="Enter reason for return..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-undo"></i> Log Return Action</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Returns Audit Trails</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Return Category</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returns as $ret)
                            <tr>
                                <td><strong>{{ $ret->medicine->name }}</strong></td>
                                <td><strong>{{ $ret->quantity }} Units</strong></td>
                                <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $ret->type }}</span></td>
                                <td style="font-size:12px; color:var(--text-muted);">{{ $ret->reason }}</td>
                                <td><span class="status-pill status-{{ $ret->status }}">{{ ucfirst($ret->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No returns logged today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $returns->links() }}
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

    .return-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .return-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .return-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .return-form select,
    .return-form input,
    .return-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .return-form select:focus,
    .return-form input:focus,
    .return-form textarea:focus {
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
