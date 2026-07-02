@extends('layouts.inventory', ['title' => 'Inventory ERP Command'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Summary Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon icon-orange"><i class="fa-solid fa-boxes-stacked"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Items</span>
                <strong class="stat-value">{{ $metrics['total_items'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="stat-info">
                <span class="stat-label">Low Stock</span>
                <strong class="stat-value text-danger">{{ $metrics['low_stock'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="fa-solid fa-landmark"></i></div>
            <div class="stat-info">
                <span class="stat-label">Total Assets</span>
                <strong class="stat-value">{{ $metrics['total_assets'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="fa-solid fa-microscope"></i></div>
            <div class="stat-info">
                <span class="stat-label">Operational Tech</span>
                <strong class="stat-value">{{ $metrics['equipment_operational'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-emerald"><i class="fa-solid fa-bed"></i></div>
            <div class="stat-info">
                <span class="stat-label">Beds Free</span>
                <strong class="stat-value">{{ $metrics['beds_available'] }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon icon-purple"><i class="fa-solid fa-hospital-user"></i></div>
            <div class="stat-info">
                <span class="stat-label">Beds Occupied</span>
                <strong class="stat-value">{{ $metrics['beds_occupied'] }}</strong>
            </div>
        </div>
    </div>

    <!-- Main Grid layout -->
    <div class="main-grid">
        <!-- Left: Hourly bed occupancy -->
        <div class="content-left">
            <div class="panel">
                <div class="panel-header">
                    <h2>Ward Bed Occupancy Rates</h2>
                </div>
                <div class="chart-container" style="position: relative; height:240px; width:100%;">
                    <canvas id="inventoryBedsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Right: Alarms and Quick Actions -->
        <div class="content-right">
            <!-- Critical Warnings panel -->
            <div class="panel warnings-panel">
                <div class="panel-header">
                    <h2><i class="fa-solid fa-bell"></i> Logistics Alarms</h2>
                </div>
                <div class="alarms-list">
                    <div class="alarm-item warning">
                        <strong>Defibrillator Calibration</strong>
                        <span>Due: Jul 10, 2026</span>
                    </div>
                    <div class="alarm-item danger">
                        <strong>Surgical Gloves Size M</strong>
                        <span>Stock: 0 boxes remaining</span>
                    </div>
                </div>
            </div>

            <!-- Quick ERP Actions -->
            <div class="panel">
                <div class="panel-header">
                    <h2>Quick Links</h2>
                </div>
                <div class="quick-actions-list">
                    <a href="{{ route('inventory.goods-receipt') }}" class="btn btn-primary full-width-btn"><i class="fa-solid fa-file-invoice"></i> Goods Receipts check-ins</a>
                    <a href="{{ route('inventory.beds') }}" class="btn btn-soft full-width-btn"><i class="fa-solid fa-bed"></i> Bed status dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load Chart.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('inventoryBedsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['General Ward', 'ICU', 'NICU', 'PICU', 'OT', 'Isolation'],
            datasets: [{
                label: 'Beds occupied count',
                data: [15, 8, 4, 3, 2, 1],
                backgroundColor: '#f97316',
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

    .icon-orange { background-color: rgba(249, 115, 22, 0.08); color: var(--brand-primary); }
    .icon-red { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }
    .icon-blue { background-color: rgba(56, 189, 248, 0.08); color: #0ea5e9; }
    .icon-green { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
    .icon-emerald { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
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
