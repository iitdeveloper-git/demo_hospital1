@extends('layouts.laboratory', ['title' => 'Equipment Maintenance Logs'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Laboratory Analyzers & Equipment Logs</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Equipment ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Last Calibration/Maintenance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipments as $equip)
                    <tr>
                        <td>EQ-{{ str_pad((string)$equip->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $equip->name }}</strong></td>
                        <td>{{ $equip->type }}</td>
                        <td>{{ $equip->maintenance_date ? \Carbon\Carbon::parse($equip->maintenance_date)->format('M d, Y') : 'Pending Calibration' }}</td>
                        <td><span class="status-pill status-{{ $equip->status }}">{{ ucfirst($equip->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No equipment logged in LIMS database.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $equipments->links() }}
    </div>
</div>
@endsection
