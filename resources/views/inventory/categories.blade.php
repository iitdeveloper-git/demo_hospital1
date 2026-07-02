@extends('layouts.inventory', ['title' => 'Consumable Categories'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Consumable Categories</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Category ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>CAT-{{ str_pad((string)$cat->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td style="font-size:13px; color:var(--text-muted);">{{ $cat->description ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">No categories registered in LIMS.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $categories->links() }}
    </div>
</div>
@endsection
