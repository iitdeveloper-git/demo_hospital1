@extends('layouts.laboratory', ['title' => 'Reagent Stock Management'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Chemical Reagents & Buffer Stock Inventory</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Reagent ID</th>
                    <th>Name</th>
                    <th>Batch Number</th>
                    <th>Expiry Date</th>
                    <th>Current Stock</th>
                    <th>Alert Limit</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reagents as $reagent)
                    <tr>
                        <td>RG-{{ str_pad((string)$reagent->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $reagent->name }}</strong></td>
                        <td><code>{{ $reagent->batch_number }}</code></td>
                        <td>{{ $reagent->expiry_date ? \Carbon\Carbon::parse($reagent->expiry_date)->format('M d, Y') : 'N/A' }}</td>
                        <td><strong>{{ $reagent->stock }} Units</strong></td>
                        <td><span style="color:#ef4444; font-weight:700;">{{ $reagent->low_stock_level }} Units</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No reagent records entered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $reagents->links() }}
    </div>
</div>
@endsection
