@extends('layouts.hr', ['title' => 'Clock-In Attendance Log'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>GPS/Biometric Shift Attendance</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Check In Time</th>
                    <th>Check Out Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendance as $log)
                    <tr>
                        <td>
                            <strong>{{ $log->employee->full_name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $log->employee->employee_code }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($log->check_in)->format('M d, Y - h:i A') }}</td>
                        <td>{{ $log->check_out ? \Carbon\Carbon::parse($log->check_out)->format('M d, Y - h:i A') : 'Clocked In' }}</td>
                        <td><span class="status-pill status-{{ $log->status }}">{{ ucfirst($log->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No attendance records generated today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $attendance->links() }}
    </div>
</div>
@endsection
