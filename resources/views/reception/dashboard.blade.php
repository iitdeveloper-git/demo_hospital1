@extends('layouts.reception', ['title' => 'Front Desk Command Center'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-teal"><i class="fa-solid fa-notes-medical"></i></div>
            <div class="stat-info">
                <span class="stat-label">Walk-ins Today</span>
                <strong class="stat-value">{{ $metrics['walk_ins'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Appointments</span>
                <strong class="stat-value">{{ $metrics['appointments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">Waiting in Queue</span>
                <strong class="stat-value">{{ $metrics['waiting'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-user-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Checked-In</span>
                <strong class="stat-value">{{ $metrics['checked_in'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-bed"></i></div>
            <div class="stat-info">
                <span class="stat-label">Admitted Patients</span>
                <strong class="stat-value">{{ $metrics['admissions'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-sky"><i class="fa-solid fa-id-badge"></i></div>
            <div class="stat-info">
                <span class="stat-label">Visitors Logged</span>
                <strong class="stat-value">{{ $metrics['visitors'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly outpatient traffic chart -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Desk Outpatient Volume (Hourly Load)</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="receptionLoadChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Bed Occupancy and Quick Actions -->
        <div class="content-right">
            <!-- Bed Allocation Summary -->
            <div class="panel beds-panel-reception">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bed"></i> Ward Availability</h2>
                </div>
                <div class="beds-details-grid">
                    <div class="bed-item">
                        <span class="label">General Ward</span>
                        <strong>{{ $beds['general'] }} Beds</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">Private Rooms</span>
                        <strong>{{ $beds['private'] }} Rooms</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">Semi Private</span>
                        <strong>{{ $beds['semi_private'] }} Beds</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">ICU / Emergency</span>
                        <strong class="text-danger">{{ $beds['icu'] }} Units</strong>
                    </div>
                </div>
            </div>

            <!-- Quick desk actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Desk Short-cuts</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('reception.new-patient') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-user-plus"></i> New Patient Form</a>
                    <a href="{{ route('reception.walk-in') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-notes-medical"></i> Instant Walk-in Booking</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('receptionLoadChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['09:00 AM', '11:00 AM', '01:00 PM', '03:00 PM', '05:00 PM', '07:00 PM'],
            datasets: [{
                label: 'Checked-in outpatients',
                data: [15, 34, 25, 42, 28, 12],
                backgroundColor: '#0d9488',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

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

    .icon-teal { background-color: rgba(13, 148, 136, 0.08); color: var(--brand-primary); }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-sky { background-color: rgba(2, 132, 199, 0.08); color: #0284c7; }

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

    /* Bed status styling */
    .beds-panel-reception {
        border-left: 4px solid var(--brand-primary);
    }

    .beds-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .bed-item {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 12px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .bed-item .label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
    }

    .bed-item strong {
        font-size: 18px;
    }

    .text-danger { color: #ef4444; }

    .quick-actions-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .full-width-btn {
        width: 100%;
        box-sizing: border-box;
        justify-content: center;
    }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endsection
