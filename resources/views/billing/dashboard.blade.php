@extends('layouts.billing', ['title' => 'Financial Command Command'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-indigo"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <div class="stat-info">
                <span class="stat-label">Today's Revenue</span>
                <strong class="stat-value">${{ number_format($metrics['today_revenue'], 2) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-wallet"></i></div>
            <div class="stat-info">
                <span class="stat-label">Monthly Revenue</span>
                <strong class="stat-value">${{ number_format($metrics['monthly_revenue'], 2) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-hourglass-half"></i></div>
            <div class="stat-info">
                <span class="stat-label">Outstanding Balances</span>
                <strong class="stat-value text-warning">${{ number_format($metrics['outstanding'], 2) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-undo"></i></div>
            <div class="stat-info">
                <span class="stat-label">Pending Refunds</span>
                <strong class="stat-value text-danger">${{ number_format($metrics['pending_refunds'], 2) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="stat-info">
                <span class="stat-label">Active Claims</span>
                <strong class="stat-value">{{ $metrics['claims_count'] }} Claims</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-piggy-bank"></i></div>
            <div class="stat-info">
                <span class="stat-label">Patient Wallets</span>
                <strong class="stat-value">${{ number_format($metrics['wallet_balances'], 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly revenue load -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Monthly Revenue Collections Growth</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="billingRevenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Low Stock & Expiry warnings -->
        <div class="content-right">
            <!-- Critical Warnings panel -->
            <div class="panel warnings-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bell"></i> Financial Alerts</h2>
                </div>
                <div class="alarms-list">
                    <div class="alarm-item warning">
                        <strong>Insurance Claim Policy #99201</strong>
                        <span>Status: Pending Carrier Review</span>
                    </div>
                    <div class="alarm-item danger">
                        <strong>Refund Authorization (INV-8821)</strong>
                        <span>Status: Waiting Manager Approval</span>
                    </div>
                </div>
            </div>

            <!-- Quick ERP Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('billing.create') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-file-circle-plus"></i> Generate Outpatient Bill</a>
                    <a href="{{ route('billing.payments') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-cash-register"></i> Open POS Cash Register</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('billingRevenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Monthly Revenue ($)',
                data: [15000, 22000, 28000, 24000, 31000, 42000],
                borderColor: '#6366f1',
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

    .icon-indigo { background-color: rgba(99, 102, 241, 0.08); color: var(--brand-primary); }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-red { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }
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
