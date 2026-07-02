@extends('layouts.pharmacy', ['title' => 'Pharmacy ERP Command'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-emerald"><i class="fa-solid fa-coins"></i></div>
            <div class="stat-info">
                <span class="stat-label">Today's Sales</span>
                <strong class="stat-value">${{ number_format($metrics['today_sales'], 2) }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-pills"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Items</span>
                <strong class="stat-value">{{ $metrics['total_medicines'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <span class="stat-label">Low Stock</span>
                <strong class="stat-value">{{ $metrics['low_stock'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-ban"></i></div>
            <div class="stat-info">
                <span class="stat-label">Out of Stock</span>
                <strong class="stat-value text-danger">{{ $metrics['out_of_stock'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-gold"><i class="fa-solid fa-calendar-times"></i></div>
            <div class="stat-info">
                <span class="stat-label">Expiring soon</span>
                <strong class="stat-value">{{ $metrics['expiring_soon'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-prescription"></i></div>
            <div class="stat-info">
                <span class="stat-label">Rx Today</span>
                <strong class="stat-value">{{ $metrics['prescriptions_today'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly sales load -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Pharmacy POS Billing Volume (Hourly Sales)</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="pharmacySalesChart"></canvas>
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
                    <div class="alarm-item warning">
                        <strong>Amoxicillin 500mg (Batch #1002)</strong>
                        <span>Low Stock: 2 items remaining</span>
                    </div>
                    <div class="alarm-item danger">
                        <strong>Metformin 850mg (Batch #992)</strong>
                        <span>Expired Date: Jun 28, 2026</span>
                    </div>
                </div>
            </div>

            <!-- Quick ERP Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('pharmacy.sales') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-cart-shopping"></i> POS Billing registers</a>
                    <a href="{{ route('pharmacy.prescriptions') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-prescription"></i> Doctor Prescriptions Desk</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('pharmacySalesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['09:00 AM', '11:00 AM', '01:00 PM', '03:00 PM', '05:00 PM', '07:00 PM'],
            datasets: [{
                label: 'POS Sales Total ($)',
                data: [120, 350, 480, 290, 600, 150],
                backgroundColor: '#10b981',
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

    .icon-emerald { background-color: rgba(16, 185, 129, 0.08); color: var(--brand-primary); }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: #f97316; }
    .icon-red { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }
    .icon-gold { background-color: rgba(245, 158, 11, 0.08); color: #eab308; }
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
