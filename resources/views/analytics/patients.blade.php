@extends('layouts.analytics', ['title' => 'Patient Demographics & Growth BI'])

@section('content')
<div class="glass-panel">
    <h2>Demographics Analytics</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive summaries of patient age distribution, gender split, and visit frequencies.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Age Distribution (OPD vs IPD)</h3>
            <div style="height:280px; position:relative;">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <div class="glass-panel">
            <h3>Gender Split Percentage</h3>
            <div style="height:280px; position:relative;">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ['0-18', '19-35', '36-50', '51-65', '66+'],
                datasets: [{
                    label: 'Active Patients Count',
                    data: [320, 540, 890, 620, 240],
                    backgroundColor: 'rgba(15, 111, 255, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Female', 'Male', 'Non-Binary'],
                datasets: [{
                    data: [54, 43, 3],
                    backgroundColor: ['#ef4444', '#0f6fff', '#14b8a6']
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
