@extends('layouts.inventory', ['title' => 'Consumables Inventory Stock'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Consumables Inventory Stock</h2>
        <form action="{{ route('inventory.items') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search consumables..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Consumable Name</th>
                    <th>Category</th>
                    <th>Price ($)</th>
                    <th>Warehouse Room</th>
                    <th>Reorder Limit</th>
                    <th>In Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td><code>{{ $item->item_code }}</code></td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ $item->category->name }}</td>
                        <td>${{ number_format($item->purchase_price, 2) }}</td>
                        <td>{{ $item->warehouse->name }}</td>
                        <td>{{ $item->reorder_level }} Units</td>
                        <td>
                            <strong style="color:{{ $item->current_stock <= $item->reorder_level ? '#ef4444' : 'inherit' }};">
                                {{ $item->current_stock }} Units
                            </strong>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No consumables registered in inventory.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $items->links() }}
    </div>
</div>
@endsection
