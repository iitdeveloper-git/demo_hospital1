@extends('layouts.analytics', ['title' => 'Doctor Efficiency & Rating BI'])

@section('content')
<div class="glass-panel">
    <h2>Doctor Performance Audits</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive summaries of patient ratings, follow-up rates, and prescription counts by clinical specialist.</p>
    
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Average Consultation Duration</h3>
            <div style="height:280px; position:relative;">
                <canvas id="docConsultChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Patient Rating Index</h3>
            <div style="height:280px; position:relative;">
                <canvas id="docRatingChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const consultCtx = document.getElementById('docConsultChart').getContext('2d');
        new Chart(consultCtx, {
            type: 'bar',
            data: {
                labels: ['Dr. Sharma', 'Dr. Patel', 'Dr. Verma', 'Dr. Nair'],
                datasets: [{
                    label: 'Minutes per Patient',
                    data: [15, 18, 12, 22],
                    backgroundColor: 'rgba(139, 92, 246, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const ratingCtx = document.getElementById('docRatingChart').getContext('2d');
        new Chart(ratingCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Rating Score (out of 5)',
                    data: [4.7, 4.8, 4.6, 4.9, 4.8, 4.9],
                    borderColor: '#0f6fff',
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
