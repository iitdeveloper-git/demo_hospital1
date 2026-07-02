@extends('layouts.hr', ['title' => 'HRMS Command Console'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-sky"><i class="fa-solid fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Employees</span>
                <strong class="stat-value">{{ $metrics['total_employees'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-user-check"></i></div>
            <div class="stat-info">
                <span class="stat-label">Active Employees</span>
                <strong class="stat-value">{{ $metrics['active_employees'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-user-md"></i></div>
            <div class="stat-info">
                <span class="stat-label">Doctors Count</span>
                <strong class="stat-value">{{ $metrics['doctors'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-user-nurse"></i></div>
            <div class="stat-info">
                <span class="stat-label">Nurses Count</span>
                <strong class="stat-value">{{ $metrics['nurses'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-emerald"><i class="fa-solid fa-clock"></i></div>
            <div class="stat-info">
                <span class="stat-label">Attendance Today</span>
                <strong class="stat-value">{{ $metrics['attendance_today'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-umbrella-beach"></i></div>
            <div class="stat-info">
                <span class="stat-label">On Leave Today</span>
                <strong class="stat-value text-danger">{{ $metrics['leave_today'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly shifts load -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Shift Allocation Distribution</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="hrShiftsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Low Stock & Expiry warnings -->
        <div class="content-right">
            <!-- Critical Warnings panel -->
            <div class="panel warnings-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bell"></i> HR Alerts</h2>
                </div>
                <div class="alarms-list">
                    <div class="alarm-item warning">
                        <strong>Leave Request - Dr. Jane</strong>
                        <span>Status: Pending Department Approval</span>
                    </div>
                    <div class="alarm-item danger">
                        <strong>Missing Document - Access ID #092</strong>
                        <span>Asset: Laptop Tag Pending Upload</span>
                    </div>
                </div>
            </div>

            <!-- Quick ERP Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('hr.employees') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-user-plus"></i> Onboard New Employee</a>
                    <a href="{{ route('hr.leave') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-umbrella-beach"></i> Open Leave Desk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('hrShiftsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Morning Shift', 'Evening Shift', 'Night Shift', 'On-Call/ER'],
            datasets: [{
                label: 'Staff assigned count',
                data: [45, 30, 15, 8],
                backgroundColor: '#0ea5e9',
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

    .icon-sky { background-color: rgba(14, 165, 233, 0.08); color: var(--brand-primary); }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-purple { background-color: rgba(139, 92, 246, 0.08); color: #8b5cf6; }
    .icon-emerald { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
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
