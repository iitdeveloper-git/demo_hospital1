@extends('layouts.analytics', ['title' => 'Finance & Operating Profit Margins'])

@section('content')
<div class="glass-panel">
    <h2>Financial Auditing Indicators</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive summaries of operating revenues, expenses, profit scale, and outstanding patient claims.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Year-Over-Year Cash Flow Breakdown</h3>
            <div style="height:280px; position:relative;">
                <canvas id="finFlowChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Claims Resolution Ratios</h3>
            <div style="height:280px; position:relative;">
                <canvas id="finClaimsChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const flowCtx = document.getElementById('finFlowChart').getContext('2d');
        new Chart(flowCtx, {
            type: 'bar',
            data: {
                labels: ['2023', '2024', '2025', '2026'],
                datasets: [{
                    label: 'Net Profits (₹)',
                    data: [15000000, 18200000, 22400000, 28500000],
                    backgroundColor: 'rgba(15, 111, 255, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const claimsCtx = document.getElementById('finClaimsChart').getContext('2d');
        new Chart(claimsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Approved Claims', 'Pending Audits', 'Rejected claims'],
                datasets: [{
                    data: [75, 15, 10],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
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
