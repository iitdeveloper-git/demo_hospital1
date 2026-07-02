@extends('layouts.analytics', ['title' => 'OPD Visits & Appointment Density BI'])

@section('content')
<div class="glass-panel">
    <h2>Visits Load & Scheduling Density</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive summaries of OPD/IPD scheduling peaks, waiting times, and cancellation rates.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Visits Peak Hours (Density)</h3>
            <div style="height:280px; position:relative;">
                <canvas id="apptDensityChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Avg Patient Wait Time (Minutes)</h3>
            <div style="height:280px; position:relative;">
                <canvas id="apptWaitChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const denCtx = document.getElementById('apptDensityChart').getContext('2d');
        new Chart(denCtx, {
            type: 'line',
            data: {
                labels: ['09:00 AM', '11:00 AM', '01:00 PM', '03:00 PM', '05:00 PM'],
                datasets: [{
                    label: 'Scheduled Patients count',
                    data: [150, 420, 210, 310, 180],
                    borderColor: '#14b8a6',
                    fill: true,
                    backgroundColor: 'rgba(20, 184, 166, 0.08)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const waitCtx = document.getElementById('apptWaitChart').getContext('2d');
        new Chart(waitCtx, {
            type: 'bar',
            data: {
                labels: ['General Medicine', 'Cardiology', 'Pediatrics', 'ENT'],
                datasets: [{
                    label: 'Wait time (Min)',
                    data: [25, 45, 15, 20],
                    backgroundColor: 'rgba(15, 111, 255, 0.45)'
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
