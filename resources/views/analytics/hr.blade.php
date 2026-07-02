@extends('layouts.analytics', ['title' => 'HRMS Employee Attendance & Payroll BI'])

@section('content')
<div class="glass-panel">
    <h2>Workforce Attendance & Turnover Audits</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive summaries of attendance patterns, overtime metrics, and employee payroll scales.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Attendance Percentage by Department</h3>
            <div style="height:280px; position:relative;">
                <canvas id="hrAttendChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Monthly Overtime Margins</h3>
            <div style="height:280px; position:relative;">
                <canvas id="hrOvertimeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const attCtx = document.getElementById('hrAttendChart').getContext('2d');
        new Chart(attCtx, {
            type: 'bar',
            data: {
                labels: ['Cardiology', 'Neurology', 'Orthopedics', 'Pediatrics', 'Emergency'],
                datasets: [{
                    label: 'Attendance (%)',
                    data: [98.4, 95.2, 92.1, 96.0, 99.1],
                    backgroundColor: 'rgba(15, 111, 255, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const otCtx = document.getElementById('hrOvertimeChart').getContext('2d');
        new Chart(otCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Overtime Hours Logged',
                    data: [120, 145, 90, 80, 160, 210],
                    borderColor: '#8b5cf6',
                    fill: false
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
