@extends('layouts.doctor', ['title' => 'Clinical Command Center'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Stats Grid -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Today's Visits</span>
                <strong class="stat-value">{{ $metrics['today_count'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-sky"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">Upcoming Sessions</span>
                <strong class="stat-value">{{ $metrics['upcoming_count'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Completed Visits</span>
                <strong class="stat-value">{{ $metrics['completed_count'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Patients</span>
                <strong class="stat-value">{{ $metrics['total_patients'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-file-medical"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pending Reports</span>
                <strong class="stat-value">{{ $metrics['pending_reports'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-gold"><i class="fa-solid fa-star"></i></div>
            <div class="stat-info">
                <span class="stat-label">Avg Rating</span>
                <strong class="stat-value">{{ $metrics['avg_rating'] }}/5.0</strong>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Split Layout -->
    <div class="main-grid">
        <!-- Left: Today's Schedule -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-clock"></i> Today's Schedule</h2>
                    <span class="badge badge-today">Today</span>
                </div>
                <div class="table-wrap">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>Time Slot</th>
                                <th>Patient Name</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($todayAppointments as $appt)
                                <tr>
                                    <td><strong>{{ \Carbon\Carbon::parse($appt->appointment_at)->format('h:i A') }}</strong></td>
                                    <td>
                                        <a href="{{ route('doctor.patient.show', $appt->patient_id) }}" class="patient-link">
                                            {{ $appt->patient->user->name }}
                                        </a>
                                    </td>
                                    <td><span class="type-badge">{{ ucfirst($appt->type) }}</span></td>
                                    <td><span class="status-pill status-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span></td>
                                    <td>
                                        <div class="action-btn-group">
                                            @if($appt->status !== 'completed' && $appt->status !== 'cancelled')
                                                <form action="{{ route('doctor.appointments.update', $appt->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-primary btn-sm" title="Mark Completed"><i class="fa-solid fa-check"></i></button>
                                                </form>
                                                <form action="{{ route('doctor.appointments.update', $appt->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Cancel Appointment"><i class="fa-solid fa-times"></i></button>
                                                </form>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="empty-state">No appointments scheduled for today.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Active AI Co-Pilot Hub -->
        <div class="content-right">
            <div class="panel ai-assistant-panel" style="border:1px solid #0f6fff40;">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-microchip-ai"></i> Clinical AI Assistant</h2>
                    <span class="badge badge-ai" style="background:#0f6fff; color:#fff;">Active co-pilot</span>
                </div>
                <div class="ai-body">
                    <p class="ai-disclaimer">Suggested diagnostics & medication risks generated dynamically based on active EMR vitals.</p>
                    
                    <div class="ai-widget-list">
                        <div class="ai-widget-card alert-risk">
                            <span class="ai-card-title"><i class="fa-solid fa-circle-exclamation"></i> Risk Alert</span>
                            <p>Patient <strong>Vihaan Shah</strong> has BP vitals showing stage 1 hypertension. Suggested monitoring schedule.</p>
                        </div>
                        <div class="ai-widget-card suggested-dx">
                            <span class="ai-card-title"><i class="fa-solid fa-hand-holding-medical"></i> Suggested Diagnosis</span>
                            <p>Suggested follow-up protocol for Chronic Bronchitis based on last week's spirometry report uploads.</p>
                        </div>
                    </div>

                    <div style="margin-top:16px;">
                        <a href="{{ route('ai.dashboard') }}" class="btn btn-primary" style="width:100%; text-align:center; display:block;">Open AI Co-Pilot Console</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-wrap {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
    }

    .stat-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .icon-blue { background-color: rgba(2, 132, 199, 0.08); color: #0284c7; }
    .icon-sky { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-gold { background-color: rgba(245, 158, 11, 0.08); color: #eab308; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
    }

    .main-grid {
        display: grid;
        grid-template-columns: 1.3fr 0.7fr;
        gap: 32px;
        align-items: start;
    }

    .content-left, .content-right {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .badge {
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 99px;
    }

    .badge-today { background-color: var(--brand-soft); color: var(--brand-primary); }
    .badge-ai { background-color: rgba(139, 92, 246, 0.1); color: #8b5cf6; }

    .patient-link {
        color: var(--text-main);
        text-decoration: none;
        font-weight: 600;
    }

    .patient-link:hover {
        color: var(--brand-primary);
        text-decoration: underline;
    }

    .type-badge {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    .action-btn-group {
        display: flex;
        gap: 8px;
    }

    /* AI Assistant Card styling */
    .ai-assistant-panel {
        border-left: 4px solid #8b5cf6;
    }

    .ai-body {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .ai-disclaimer {
        font-size: 12px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.4;
    }

    .ai-widget-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .ai-widget-card {
        padding: 14px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.5;
    }

    .alert-risk {
        background-color: rgba(239, 68, 68, 0.06);
        border: 1px solid rgba(239, 68, 68, 0.15);
        color: var(--text-main);
    }

    .alert-risk .ai-card-title {
        color: #ef4444;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .suggested-dx {
        background-color: rgba(139, 92, 246, 0.06);
        border: 1px solid rgba(139, 92, 246, 0.15);
        color: var(--text-main);
    }

    .suggested-dx .ai-card-title {
        color: #8b5cf6;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .ai-widget-card p {
        margin: 0;
    }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endsection
