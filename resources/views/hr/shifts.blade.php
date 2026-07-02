@extends('layouts.hr', ['title' => 'Shift Swapping & Schedules'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Shift Schedules</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Assigned Shift Type</th>
                    <th>Time Bounds</th>
                </tr>
            </thead>
            <tbody>
                @forelse($shifts as $shift)
                    <tr>
                        <td><strong>{{ $shift->employee->full_name }}</strong></td>
                        <td><span class="status-pill status-scheduled">{{ ucfirst($shift->shift_type) }}</span></td>
                        <td><code>{{ $shift->start_time }} - {{ $shift->end_time }}</code></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">No shift schedules mapped.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $shifts->links() }}
    </div>
</div>
@endsection
