@extends('layouts.pharmacy', ['title' => 'Medicines Catalog'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Active Medicines Inventory</h2>
        <form action="{{ route('pharmacy.medicines') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicine name..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Item Code</th>
                    <th>Medicine Name</th>
                    <th>Strength</th>
                    <th>Form</th>
                    <th>Manufacturer</th>
                    <th>Stock</th>
                    <th>MRP ($)</th>
                    <th>Expiry Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($medicines as $med)
                    <tr>
                        <td><code>{{ $med->medicine_code }}</code></td>
                        <td>
                            <strong>{{ $med->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">Generic: {{ $med->generic_name }}</span>
                        </td>
                        <td>{{ $med->strength }}</td>
                        <td><span class="type-badge">{{ ucfirst($med->dosage_form) }}</span></td>
                        <td>{{ $med->manufacturer }}</td>
                        <td>
                            <strong style="color:{{ $med->stock <= $med->reorder_level ? '#ef4444' : 'inherit' }};">
                                {{ $med->stock }} Units
                            </strong>
                        </td>
                        <td><strong>${{ number_format($med->mrp, 2) }}</strong></td>
                        <td>{{ $med->expires_at ? \Carbon\Carbon::parse($med->expires_at)->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">No medicines registered in stock.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $medicines->links() }}
    </div>
</div>

<style>
    .type-badge {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
</style>
@endsection
