@extends('layouts.analytics', ['title' => 'Laboratory Diagnostic Orders & Anomaly BI'])

@section('content')
<div class="glass-panel">
    <h2>LIMS Operations Summary</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Audit of most ordered diagnostics tests, technician performance indexes, and laboratory revenue.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Test Modalities Volume</h3>
            <div style="height:280px; position:relative;">
                <canvas id="labTestChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Technician Processing Speed</h3>
            <div style="height:280px; position:relative;">
                <canvas id="labSpeedChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const testCtx = document.getElementById('labTestChart').getContext('2d');
        new Chart(testCtx, {
            type: 'doughnut',
            data: {
                labels: ['CBC Panel', 'Blood Glucose', 'Lipid Profile', 'Thyroid Profile'],
                datasets: [{
                    data: [1200, 850, 600, 420],
                    backgroundColor: ['#0f6fff', '#14b8a6', '#8b5cf6', '#f59e0b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const speedCtx = document.getElementById('labSpeedChart').getContext('2d');
        new Chart(speedCtx, {
            type: 'bar',
            data: {
                labels: ['Technician A', 'Technician B', 'Technician C'],
                datasets: [{
                    label: 'Avg Minutes/Report',
                    data: [45, 32, 50],
                    backgroundColor: 'rgba(139, 92, 246, 0.45)'
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
