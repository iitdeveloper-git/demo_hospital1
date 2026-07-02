@extends('layouts.patient', ['title' => 'Dashboard Overview'])

@section('content')
<div class="dashboard-wrap">
    <!-- Stat Grid -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Visits</span>
                <strong class="stat-value">{{ $metrics['total_appointments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-teal"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-info">
                <span class="stat-label">Upcoming</span>
                <strong class="stat-value">{{ $metrics['upcoming_appointments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-prescription-bottle-medical"></i></div>
            <div class="stat-info">
                <span class="stat-label">Active Prescriptions</span>
                <strong class="stat-value">{{ $metrics['active_prescriptions'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-credit-card"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pending Balance</span>
                <strong class="stat-value">${{ number_format($metrics['pending_bills'], 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="main-grid">
        <!-- Left Column: Details -->
        <div class="content-left">
            <!-- Next Appointment Card -->
            @if($nextAppointment)
                <div class="panel next-appt-panel">
                    <div class="panel-header">
                        <h2><i class="fa-solid fa-calendar-day"></i> Next Scheduled Appointment</h2>
                        <span class="badge badge-success">Scheduled</span>
                    </div>
                    <div class="next-appt-body">
                        <div class="appt-meta">
                            <div class="doctor-photo">
                                @if($nextAppointment->doctor->photo)
                                    <img src="{{ $nextAppointment->doctor->photo }}" alt="{{ $nextAppointment->doctor->full_name }}">
                                @else
                                    <i class="fa-solid fa-user-doctor"></i>
                                @endif
                            </div>
                            <div>
                                <h3>{{ $nextAppointment->doctor->full_name }}</h3>
                                <p>{{ $nextAppointment->department->name }} Department</p>
                            </div>
                        </div>
                        <div class="appt-time">
                            <div class="time-item">
                                <i class="fa-solid fa-calendar"></i>
                                <span>{{ \Carbon\Carbon::parse($nextAppointment->appointment_at)->format('l, F j, Y') }}</span>
                            </div>
                            <div class="time-item">
                                <i class="fa-solid fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($nextAppointment->appointment_at)->format('h:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="panel no-appt-panel">
                    <h3>No Upcoming Appointments</h3>
                    <p>Schedule your next consultation or OPD check-up online.</p>
                    <a href="{{ route('patient.appointments') }}" class="btn btn-primary btn-sm">Book Appointment</a>
                </div>
            @endif

            <!-- Recent Reports Panel -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Recent Lab & Radiology Reports</h2>
                    <a href="{{ route('patient.reports') }}" class="view-all-link">View All</a>
                </div>
                <div class="table-wrap">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>Report Title</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $report)
                                <tr>
                                    <td><strong>{{ $report->title }}</strong></td>
                                    <td><span class="report-badge">{{ strtoupper($report->report_type) }}</span></td>
                                    <td><span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($report->reported_at)->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">No clinical reports available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Prescription/Bills -->
        <div class="content-right">
            <!-- Active Prescriptions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Active Prescriptions</h2>
                    <a href="{{ route('patient.prescriptions') }}" class="view-all-link">View All</a>
                </div>
                <div class="prescription-list">
                    @forelse($prescriptions as $rx)
                        <div class="prescription-item">
                            <div class="rx-icon"><i class="fa-solid fa-pills"></i></div>
                            <div class="rx-details">
                                <h4>{{ $rx->medication_name }}</h4>
                                <span class="rx-meta">{{ $rx->dosage }} - {{ $rx->frequency }}</span>
                                <span class="rx-doctor">By {{ $rx->doctor->full_name }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="empty-state">No active prescriptions.</p>
                    @endforelse
                </div>
            </div>

            <!-- Invoices / Bills -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Recent Invoices</h2>
                    <a href="{{ route('patient.payments') }}" class="view-all-link">View All</a>
                </div>
                <div class="bill-list">
                    @forelse($bills as $bill)
                        <div class="bill-item">
                            <div class="bill-info">
                                <strong>{{ $bill->invoice_number }}</strong>
                                <span>Due: {{ \Carbon\Carbon::parse($bill->due_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="bill-actions">
                                <span class="bill-amount">${{ number_format($bill->amount, 2) }}</span>
                                <span class="status-pill status-{{ $bill->status }}">{{ ucfirst($bill->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="empty-state">No invoice statements available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Dashboard specific styles */
    .dashboard-wrap {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    /* Stat Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
    }

    .stat-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .icon-blue { background-color: rgba(37, 99, 235, 0.08); color: #2563eb; }
    .icon-teal { background-color: rgba(20, 184, 166, 0.08); color: #14b8a6; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .stat-value {
        font-size: 24px;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
    }

    /* Layout structure */
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

    .panel {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .panel-header h2 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .view-all-link {
        font-size: 13px;
        color: var(--brand-primary);
        text-decoration: none;
        font-weight: 600;
    }

    .view-all-link:hover {
        text-decoration: underline;
    }

    /* Next Appointment Card */
    .next-appt-panel {
        border-left: 4px solid #10b981;
    }

    .next-appt-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--bg-primary);
        padding: 20px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .appt-meta {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .doctor-photo {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        overflow: hidden;
        background-color: var(--border-color);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .doctor-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .doctor-photo i {
        font-size: 24px;
        color: var(--text-muted);
    }

    .appt-meta h3 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
    }

    .appt-meta p {
        margin: 0;
        font-size: 13px;
        color: var(--text-muted);
    }

    .appt-time {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .time-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
    }

    .time-item i {
        color: var(--brand-primary);
    }

    .no-appt-panel {
        text-align: center;
        padding: 36px 20px;
        background-color: var(--bg-card);
        border: 1px dashed var(--border-color);
    }

    .no-appt-panel h3 {
        margin: 0 0 8px;
        font-size: 16px;
    }

    .no-appt-panel p {
        color: var(--text-muted);
        font-size: 13px;
        margin: 0 0 16px;
    }

    /* Table styles */
    .table-wrap {
        overflow-x: auto;
        margin: 0 -24px -24px;
    }

    .portal-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 14px;
    }

    .portal-table th {
        background-color: var(--bg-primary);
        padding: 12px 24px;
        font-weight: 600;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }

    .portal-table td {
        padding: 16px 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .portal-table tr:last-child td {
        border-bottom: none;
    }

    .report-badge {
        background-color: var(--bg-primary);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid var(--border-color);
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-final, .status-paid, .status-scheduled { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .status-draft, .status-pending { background-color: rgba(245, 158, 11, 0.08); color: #f59e0b; }
    .status-review, .status-overdue { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }

    /* Prescription List */
    .prescription-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .prescription-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background-color: var(--bg-primary);
    }

    .rx-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background-color: rgba(139, 92, 246, 0.08);
        color: #8b5cf6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .rx-details {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .rx-details h4 {
        margin: 0 0 2px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .rx-meta {
        font-size: 12px;
        color: var(--text-main);
        font-weight: 500;
    }

    .rx-doctor {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* Bill list */
    .bill-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .bill-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
    }

    .bill-info {
        display: flex;
        flex-direction: column;
    }

    .bill-info strong {
        font-size: 14px;
        margin-bottom: 2px;
    }

    .bill-info span {
        font-size: 11px;
        color: var(--text-muted);
    }

    .bill-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }

    .bill-amount {
        font-weight: 700;
        font-size: 14px;
    }

    .empty-state {
        text-align: center;
        color: var(--text-muted);
        font-size: 13px;
        padding: 16px;
    }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endsection
