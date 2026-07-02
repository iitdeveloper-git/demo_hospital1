@extends('layouts.analytics', ['title' => 'Clinical Department Performance BI'])

@section('content')
<div class="glass-panel">
    <h2>Departmental Comparison Metrics</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Comparative analysis of workload distributions, patient traffic, and emergency code triggers across clinical wards.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Active Bed Occupancy Ratio</h3>
            <div style="height:280px; position:relative;">
                <canvas id="deptBedChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Monthly Patient Admissions</h3>
            <div style="height:280px; position:relative;">
                <canvas id="deptAdmitChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bedCtx = document.getElementById('deptBedChart').getContext('2d');
        new Chart(bedCtx, {
            type: 'doughnut',
            data: {
                labels: ['Cardiology', 'Neurology', 'Orthopedics', 'Emergency', 'ICU'],
                datasets: [{
                    data: [82, 64, 75, 90, 95],
                    backgroundColor: ['#0f6fff', '#14b8a6', '#8b5cf6', '#ef4444', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const admitCtx = document.getElementById('deptAdmitChart').getContext('2d');
        new Chart(admitCtx, {
            type: 'bar',
            data: {
                labels: ['Cardiology', 'Neurology', 'Orthopedics', 'Emergency', 'ICU'],
                datasets: [{
                    label: 'Admissions count',
                    data: [240, 150, 310, 850, 110],
                    backgroundColor: 'rgba(20, 184, 166, 0.45)'
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
