@extends('layouts.admin', ['title' => 'System & Hardware Health'])

@section('content')
<div class="health-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Hardware & Database Indicators</h2>
        </div>
        
        <div class="health-grid">
            <div class="health-card">
                <h3>CPU Usage</h3>
                <strong class="health-stat">{{ $system['cpu'] }}</strong>
                <span class="status-indicator online">Optimal</span>
            </div>
            <div class="health-card">
                <h3>Memory Alloc</h3>
                <strong class="health-stat">{{ $system['memory'] }}</strong>
                <span class="status-indicator online">Optimal</span>
            </div>
            <div class="health-card">
                <h3>Disk Capacity</h3>
                <strong class="health-stat">{{ $system['storage'] }}</strong>
                <span class="status-indicator online">Optimal</span>
            </div>
            <div class="health-card">
                <h3>Database Status</h3>
                <strong class="health-stat text-success">{{ $system['db_status'] }}</strong>
                <span class="status-indicator online">Connected</span>
            </div>
            <div class="health-card">
                <h3>Cache Store</h3>
                <strong class="health-stat">{{ $system['cache_status'] }}</strong>
                <span class="status-indicator online">Running</span>
            </div>
            <div class="health-card">
                <h3>App Version</h3>
                <strong class="health-stat" style="font-size:16px;">{{ $system['version'] }}</strong>
                <span class="status-indicator online">Latest</span>
            </div>
        </div>
    </div>
</div>

<style>
    .health-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        margin-top: 16px;
    }

    .health-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 20px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .health-card h3 {
        font-size: 14px;
        margin: 0;
        color: var(--text-muted);
    }

    .health-stat {
        font-size: 24px;
        font-weight: 800;
        font-family: 'Outfit', sans-serif;
    }

    .status-indicator {
        align-self: flex-start;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 4px;
    }

    .status-indicator.online {
        background-color: rgba(16, 185, 129, 0.08);
        color: #10b981;
    }
</style>
@endsection
