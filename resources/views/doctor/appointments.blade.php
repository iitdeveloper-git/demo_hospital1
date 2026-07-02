@extends('layouts.doctor', ['title' => 'Manage Appointments'])

@section('content')
<div class="appointments-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Appointments Registry</h2>
        </div>

        <div class="table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date & Time</th>
                        <th>Department</th>
                        <th>Type</th>
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
                            <td>{{ $appt->department->name }}</td>
                            <td><span class="type-badge">{{ ucfirst($appt->type) }}</span></td>
                            <td><span class="status-pill status-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                            <td>
                                @if($appt->status !== 'completed' && $appt->status !== 'cancelled')
                                    <div style="display:flex; gap:8px;">
                                        <form action="{{ route('doctor.appointments.update', $appt->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-check"></i> Complete</button>
                                        </form>
                                        <form action="{{ route('doctor.appointments.update', $appt->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-ban"></i> Cancel</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted">No actions available</span>
                                @endif
                            </td>
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
</div>
@endsection
