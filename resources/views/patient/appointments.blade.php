@extends('layouts.patient', ['title' => 'My Appointments'])

@section('content')
<div class="appointments-wrap">
    <!-- Top banner with quick booking redirect -->
    <div class="booking-promo-card">
        <div>
            <h3>Need to schedule another visit?</h3>
            <p>Select your specialist, preferred department, and request a slot instantly using our booking system.</p>
        </div>
        <a href="{{ route('public.page', 'appointment') }}" class="btn btn-primary"><i class="fa-solid fa-calendar-plus"></i> Book Consultation</a>
    </div>

    <!-- Table of Appointments -->
    <div class="panel">
        <div class="panel-header">
            <h2>Appointment Schedule</h2>
        </div>
        <div class="table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Department</th>
                        <th>Scheduled Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Triage Score</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                        <tr>
                            <td>
                                <div class="table-doc-info">
                                    <strong>{{ $appt->doctor->full_name }}</strong>
                                    <span>{{ $appt->doctor->specialization }}</span>
                                </div>
                            </td>
                            <td>{{ $appt->department->name }}</td>
                            <td>
                                <div class="table-time-info">
                                    <strong>{{ \Carbon\Carbon::parse($appt->appointment_at)->format('M d, Y') }}</strong>
                                    <span>{{ \Carbon\Carbon::parse($appt->appointment_at)->format('h:i A') }}</span>
                                </div>
                            </td>
                            <td><span class="type-badge">{{ ucfirst($appt->type) }}</span></td>
                            <td><span class="status-pill status-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                            <td>
                                <span class="triage-badge triage-{{ $appt->triage_score > 7 ? 'high' : ($appt->triage_score > 4 ? 'medium' : 'low') }}">
                                    Score: {{ $appt->triage_score }}/10
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">You have not scheduled any appointments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination-container">
            {{ $appointments->links() }}
        </div>
    </div>
</div>

<style>
    .appointments-wrap {
        display: flex;
        flex-direction: column;
        gap: 28px;
    }

    .booking-promo-card {
        background: linear-gradient(135deg, var(--brand-primary) 0%, #1e3a8a 100%);
        color: #ffffff;
        border-radius: 16px;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .booking-promo-card h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        margin: 0 0 4px;
    }

    .booking-promo-card p {
        margin: 0;
        font-size: 14px;
        color: #93c5fd;
    }

    .booking-promo-card .btn {
        background-color: #ffffff;
        color: var(--brand-primary);
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .booking-promo-card .btn:hover {
        background-color: #f8fafc;
        transform: translateY(-2px);
    }

    .table-doc-info {
        display: flex;
        flex-direction: column;
    }

    .table-doc-info strong {
        font-size: 14px;
    }

    .table-doc-info span {
        font-size: 11px;
        color: var(--text-muted);
    }

    .table-time-info {
        display: flex;
        flex-direction: column;
    }

    .table-time-info span {
        font-size: 11px;
        color: var(--text-muted);
    }

    .type-badge {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .triage-badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    .triage-low { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .triage-medium { background-color: rgba(245, 158, 11, 0.08); color: #f59e0b; }
    .triage-high { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }

    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }

    @media (max-width: 768px) {
        .booking-promo-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }
    }
</style>
@endsection
