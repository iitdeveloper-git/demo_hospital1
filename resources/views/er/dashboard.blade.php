@extends('layouts.er', ['title' => 'Trauma command center'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-rose"><i class="fa-solid fa-truck-medical"></i></div>
            <div class="stat-info">
                <span class="stat-label">ER Admissions Today</span>
                <strong class="stat-value">{{ $metrics['er_today'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <span class="stat-label">Critical Patients</span>
                <strong class="stat-value text-danger">{{ $metrics['critical'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-ambulance"></i></div>
            <div class="stat-info">
                <span class="stat-label">Ambulances Free</span>
                <strong class="stat-value">{{ $metrics['ambulances'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-truck-ramp-box"></i></div>
            <div class="stat-info">
                <span class="stat-label">Ambulances on duty</span>
                <strong class="stat-value">{{ $metrics['ambulances_duty'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-lungs"></i></div>
            <div class="stat-info">
                <span class="stat-label">Free ICU Beds</span>
                <strong class="stat-value">{{ $metrics['icu_beds_free'] }} Beds</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-hospital"></i></div>
            <div class="stat-info">
                <span class="stat-label">OT Scheduled</span>
                <strong class="stat-value">{{ $metrics['ot_scheduled'] }} Bookings</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly shifts load -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>ICU Bed Allocations</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="erBedsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Low Stock & Expiry warnings -->
        <div class="content-right">
            <!-- Critical Warnings panel -->
            <div class="panel warnings-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bell"></i> Critical Alarms</h2>
                </div>
                <div class="alarms-list">
                    @if($metrics['code_blue'] > 0)
                        <div class="alarm-item danger">
                            <strong>CODE BLUE ACTIVE</strong>
                            <span>ER Trauma Room 1 Response Required</span>
                        </div>
                    @else
                        <div class="alarm-item warning">
                            <strong>No Active Code Blue Sirens</strong>
                            <span>Standard Operational Mode</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick ERP Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list" style="display:flex; flex-direction:column; gap:12px;">
                    <form action="{{ route('er.emergency-alerts.code-blue') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger full-width-btn" style="background-color:#ef4444;"><i class="fa-solid fa-bell"></i> Trigger Code Blue</button>
                    </form>
                    <form action="{{ route('er.emergency-alerts.disaster') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger full-width-btn" style="background-color:#b91c1c;"><i class="fa-solid fa-triangle-exclamation"></i> Trigger Disaster Recall</button>
                    </form>
                    <a href="{{ route('er.patients') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-truck-medical"></i> View ER Queue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('erBedsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['General ICU', 'Cardio ICU', 'NICU', 'PICU', 'Trauma Bay'],
            datasets: [{
                label: 'Occupied ICU Beds',
                data: [12, 6, 8, 4, 3],
                backgroundColor: '#f43f5e',
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

    .icon-rose { background-color: rgba(244, 63, 94, 0.08); color: var(--brand-primary); }
    .icon-red { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }

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

    /* Warnings panel */
    .warnings-panel {
        border-left: 4px solid #ef4444;
    }

    .alarms-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .alarm-item {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 12px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 13px;
    }

    .alarm-item.warning { border-left: 3px solid #f59e0b; }
    .alarm-item.danger { border-left: 3px solid #ef4444; }

    .alarm-item span {
        font-size: 11px;
        color: var(--text-muted);
    }

    .full-width-btn {
        width: 100%;
        box-sizing: border-box;
        justify-content: center;
    }

    .text-danger { color: #ef4444; }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endsection
