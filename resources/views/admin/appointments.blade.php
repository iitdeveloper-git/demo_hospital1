@extends('layouts.admin', ['title' => 'Appointments Registry Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Global Consultations Schedule</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date & Time</th>
                    <th>Doctor</th>
                    <th>Clinical Dept</th>
                    <th>Session Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appt)
                    <tr>
                        <td>
                            <strong>{{ $appt->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $appt->patient->patient_code }}</span>
                        </td>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($appt->appointment_at)->format('M d, Y') }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ \Carbon\Carbon::parse($appt->appointment_at)->format('h:i A') }}</span>
                        </td>
                        <td>{{ $appt->doctor->full_name }}</td>
                        <td>{{ $appt->department->name }}</td>
                        <td><span class="type-badge">{{ ucfirst($appt->type) }}</span></td>
                        <td><span class="status-pill status-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No appointments recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $appointments->links() }}
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
