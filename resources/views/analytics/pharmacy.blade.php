@extends('layouts.analytics', ['title' => 'Pharmacy Inventory Sales & Margin BI'])

@section('content')
<div class="glass-panel">
    <h2>Pharmacy Performance Audits</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Audit of top-selling pharmaceutical items, expiry loss warnings, and supplier fulfillment metrics.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Sales Margins by Category</h3>
            <div style="height:280px; position:relative;">
                <canvas id="pharmCategoryChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Monthly Expiry Discards Value</h3>
            <div style="height:280px; position:relative;">
                <canvas id="pharmExpiryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const catCtx = document.getElementById('pharmCategoryChart').getContext('2d');
        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: ['Antibiotics', 'Analgesics', 'Cardiovascular', 'Antidiabetic'],
                datasets: [{
                    label: 'Net Profit Margin (%)',
                    data: [35, 20, 45, 30],
                    backgroundColor: 'rgba(15, 111, 255, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const expCtx = document.getElementById('pharmExpiryChart').getContext('2d');
        new Chart(expCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Discards Value (₹)',
                    data: [12000, 8500, 14000, 5000, 9200, 11000],
                    borderColor: '#ef4444',
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
