@extends('layouts.analytics', ['title' => 'Administrative Forecasting Center'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2>Hospital Capacity & Demand Predictions</h2>
        
        <form action="{{ route('analytics.forecast') }}" method="GET" style="display:flex; gap:12px; align-items:center;">
            <label for="type" style="font-weight:700; font-size:13px;">Forecast Target:</label>
            <select name="type" id="type" onchange="this.form.submit()">
                <option value="revenue" {{ $type === 'revenue' ? 'selected' : '' }}>Revenue Projection</option>
                <option value="patient" {{ $type === 'patient' ? 'selected' : '' }}>Patient Volume Projection</option>
                <option value="bed_demand" {{ $type === 'bed_demand' ? 'selected' : '' }}>ICU Bed Allocation Requirement</option>
                <option value="medicine_demand" {{ $type === 'medicine_demand' ? 'selected' : '' }}>Pharmacy Inventory Usage</option>
            </select>
        </form>
    </div>

    <!-- Chart Split -->
    <div style="display:grid; grid-template-columns: 1.3fr 0.7fr; gap:24px; align-items:start;">
        <!-- Left: Curve -->
        <div class="glass-panel">
            <h3>Calculated 6-Month Trend</h3>
            <div style="height:320px; position:relative;">
                <canvas id="forecastChart"></canvas>
            </div>
        </div>

        <!-- Right: Variables info -->
        <div class="glass-panel">
            <h3>Confidence Indicators</h3>
            <p style="color:var(--text-muted); font-size:13px; line-height:1.6; margin-bottom:20px;">
                Regression calculations include a baseline trend variable compounding at +{{ $forecast['growth_estimate'] }} month-over-month, adjusted with a weather-induced seasonal coefficient.
            </p>
            
            <div style="display:flex; flex-direction:column; gap:14px;">
                <div style="padding:12px; border:1px solid var(--glass-border); border-radius:8px;">
                    <span style="font-size:10px; font-weight:700; color:var(--text-muted);">GROWTH RATE</span>
                    <strong style="display:block; font-size:16px; color:#14b8a6; margin-top:4px;">+{{ $forecast['growth_estimate'] }} Monthly</strong>
                </div>
                <div style="padding:12px; border:1px solid var(--glass-border); border-radius:8px;">
                    <span style="font-size:10px; font-weight:700; color:var(--text-muted);">SEASONAL INFLUENZA MULTIPLIER</span>
                    <strong style="display:block; font-size:16px; color:#8b5cf6; margin-top:4px;">1.05x (Compounded)</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('forecastChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($forecast['labels']) !!},
                datasets: [{
                    label: 'Projected Value',
                    data: {!! json_encode($forecast['values']) !!},
                    backgroundColor: 'rgba(139, 92, 246, 0.25)',
                    borderColor: '#8b5cf6',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
