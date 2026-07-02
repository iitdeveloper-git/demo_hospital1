@extends('layouts.inventory', ['title' => 'Beds Allocation Board'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Bed Allocation Grid</h2>
    </div>

    <!-- Bed Grid Visual representation -->
    <div class="bed-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap:16px; margin-bottom:32px;">
        @foreach($beds as $bed)
            <div class="bed-item status-card" style="border:1px solid var(--border-color); border-radius:12px; padding:16px; text-align:center; background-color: var(--bg-card); display:flex; flex-direction:column; gap:8px;">
                <span class="bed-icon" style="font-size:24px; color:{{ $bed->status === 'available' ? '#10b981' : '#ef4444' }};"><i class="fa-solid fa-bed"></i></span>
                <strong style="font-size:14px;">Bed {{ $bed->bed_number }}</strong>
                <span style="font-size:10px; color:var(--text-muted); font-weight:700; text-transform:uppercase;">{{ $bed->ward->name }}</span>
                <span class="status-pill status-{{ $bed->status }}" style="font-size:9px; padding:2px 6px; justify-content:center;">{{ ucfirst($bed->status) }}</span>
            </div>
        @endforeach
    </div>

    <div class="pagination-container" style="display:flex; justify-content:flex-end;">
        {{ $beds->links() }}
    </div>
</div>
@endsection
