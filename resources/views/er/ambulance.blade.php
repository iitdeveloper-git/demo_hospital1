@extends('layouts.er', ['title' => 'Ambulance Fleet Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Active Ambulance Fleet Control</h2>
    </div>

    <!-- Live GPS Tracking Placeholder -->
    <div style="background-color:var(--bg-primary); border: 1px solid var(--border-color); border-radius:12px; padding:32px; text-align:center; margin-bottom:24px; color:var(--text-muted);">
        <i class="fa-solid fa-map-location-dot" style="font-size:48px; color:var(--brand-primary); margin-bottom:16px; display:block;"></i>
        <strong>GPS Live Location Mapping Ready</strong>
        <p style="font-size:12px; margin-top:8px;">Live feed from paramedic mobile terminals. Map renders active routes, ETA, and distance parameters automatically.</p>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Vehicle Number</th>
                    <th>Medical Setup Class</th>
                    <th>Driver / Paramedic</th>
                    <th>Availability</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ambulances as $amb)
                    <tr>
                        <td><strong>{{ $amb->vehicle_number }}</strong></td>
                        <td><span class="type-badge">{{ $amb->vehicle_type }}</span></td>
                        <td>Paramedic Team #{{ $amb->id }}</td>
                        <td><span class="status-pill status-{{ $amb->availability ? 'available' : 'occupied' }}">{{ $amb->availability ? 'Available' : 'Dispatched' }}</span></td>
                        <td><span class="status-pill status-{{ $amb->status }}">{{ ucfirst($amb->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No ambulances logged in registry.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $ambulances->links() }}
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
