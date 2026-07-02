@extends('layouts.admin', ['title' => 'Control Command Overview'])

@section('content')
<div class="dashboard-wrap">
    <!-- Stat Grid -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-user-injured"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Patients</span>
                <strong class="stat-value">{{ $metrics['total_patients'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-sky"><i class="fa-solid fa-user-md"></i></div>
            <div class="stat-info">
                <span class="stat-label">Doctors Active</span>
                <strong class="stat-value">{{ $metrics['total_doctors'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-hospital"></i></div>
            <div class="stat-info">
                <span class="stat-label">Departments</span>
                <strong class="stat-value">{{ $metrics['total_departments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Appointments Today</span>
                <strong class="stat-value">{{ $metrics['today_appointments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pending Reviews</span>
                <strong class="stat-value">{{ $metrics['pending_appointments'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-indigo"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Revenue</span>
                <strong class="stat-value">${{ number_format($metrics['total_revenue'], 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Interactive Analytics Charts -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Daily Outpatient & Operational Traffic</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <!-- Chart.js Canvas -->
                    <canvas id="revenueFlowChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Bed Occupancy and Quick Actions -->
        <div class="content-right">
            <!-- Bed Occupancy Panel -->
            <div class="panel bed-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bed"></i> Bed Allocation Monitor</h2>
                </div>
                <div class="beds-details-grid">
                    <div class="bed-item">
                        <span class="label">Available Beds</span>
                        <strong class="text-success">{{ $beds['available'] }}</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">Occupied</span>
                        <strong class="text-danger">{{ $beds['occupied'] }}</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">ICU Units</span>
                        <strong>{{ $beds['icu'] }}</strong>
                    </div>
                    <div class="bed-item">
                        <span class="label">Emergency</span>
                        <strong>{{ $beds['emergency'] }}</strong>
                    </div>
                </div>
            </div>

            <!-- Quick Admin Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Actions</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('admin.settings') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-cog"></i> Global Configurations</a>
                    <a href="{{ route('admin.system-health') }}" class="btn btn-secondary full-width-btn"><i class="fa-solid fa-server"></i> System Health Log</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('revenueFlowChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Outpatient consultations',
                data: [65, 80, 72, 85, 90, 45, 30],
                borderColor: '#4f46e5',
                tension: 0.3,
                fill: false
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
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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

    .icon-blue { background-color: rgba(79, 70, 229, 0.08); color: var(--brand-primary); }
    .icon-sky { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-indigo { background-color: rgba(99, 102, 241, 0.08); color: #6366f1; }

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

    /* Bed Occupancy monitor grid */
    .bed-panel {
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

    .text-success { color: #10b981; }
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
