@extends('layouts.reception', ['title' => 'Appointments Log'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Patient Sessions & Registrations</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date & Time</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Session Type</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                        <td>
                            <div style="display:flex; gap:8px;">
                                @if($appt->status === 'scheduled')
                                    <form action="{{ route('reception.check-in', $appt->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-sign-in-alt"></i> Check In</button>
                                    </form>
                                @elseif($appt->status === 'checked-in')
                                    <form action="{{ route('reception.check-out', $appt->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-soft btn-sm"><i class="fa-solid fa-sign-out-alt"></i> Check Out</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No appointments recorded.</td>
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
