@extends('layouts.laboratory', ['title' => 'LIMS Control Center'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-flask"></i></div>
            <div class="stat-info">
                <span class="stat-label">Today's Tests</span>
                <strong class="stat-value">{{ $metrics['today_tests'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pending Samples</span>
                <strong class="stat-value">{{ $metrics['pending_samples'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-vial"></i></div>
            <div class="stat-info">
                <span class="stat-label">Processing Samples</span>
                <strong class="stat-value">{{ $metrics['processing_samples'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Final Reports</span>
                <strong class="stat-value">{{ $metrics['completed_reports'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-circle-exclamation"></i></div>
            <div class="stat-info">
                <span class="stat-label">Critical Alerts</span>
                <strong class="stat-value text-danger">{{ $metrics['critical_reports'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly diagnostics load -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>LIMS Daily Processing Volume</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="limsVolumeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Low Reagents & Equipment Status -->
        <div class="content-right">
            <!-- Critical Alarms panel -->
            <div class="panel alarms-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-triangle-exclamation"></i> Reagent Expirations</h2>
                </div>
                <div class="alarms-list">
                    <div class="alarm-item warning">
                        <strong>CBC Reagent Batch #992</strong>
                        <span>Expiry Date: Jul 15, 2026</span>
                    </div>
                    <div class="alarm-item danger">
                        <strong>Lipid Enzymes Batch #102</strong>
                        <span>Low Stock: 5 Units remaining</span>
                    </div>
                </div>
            </div>

            <!-- Quick LIMS actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('laboratory.orders') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-clipboard-list"></i> View Test Orders</a>
                    <a href="{{ route('laboratory.samples') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-box-tissue"></i> Sample Tracking Console</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('limsVolumeChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['08:00 AM', '10:00 AM', '12:00 PM', '02:00 PM', '04:00 PM', '06:00 PM'],
            datasets: [{
                label: 'Processed blood/urine vials',
                data: [25, 45, 62, 50, 48, 30],
                borderColor: '#6d28d9',
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

    .icon-purple { background-color: rgba(109, 40, 217, 0.08); color: var(--brand-primary); }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-red { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }

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

    /* Alarms panel */
    .alarms-panel {
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

    .text-danger { color: #ef4444; }

    @media (max-width: 992px) {
        .main-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }
</style>
@endsection
