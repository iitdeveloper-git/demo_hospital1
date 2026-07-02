@extends('layouts.analytics', ['title' => 'ERP Inventory Valuations & Vendor BI'])

@section('content')
<div class="glass-panel">
    <h2>Valuation & Logistics Audits</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Executive overview of active warehouse stock values, supplier lead times, and dead stock indicators.</p>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:24px; margin-bottom:32px;">
        <div class="glass-panel">
            <h3>Fulfillment Lead Times (Days)</h3>
            <div style="height:280px; position:relative;">
                <canvas id="invVendorChart"></canvas>
            </div>
        </div>
        <div class="glass-panel">
            <h3>Category Stock Valuations</h3>
            <div style="height:280px; position:relative;">
                <canvas id="invValChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const vendorCtx = document.getElementById('invVendorChart').getContext('2d');
        new Chart(vendorCtx, {
            type: 'bar',
            data: {
                labels: ['Vendor Alpha', 'Vendor Beta', 'Vendor Gamma'],
                datasets: [{
                    label: 'Avg Deliver Time (Days)',
                    data: [3.4, 5.2, 2.1],
                    backgroundColor: 'rgba(20, 184, 166, 0.45)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        const valCtx = document.getElementById('invValChart').getContext('2d');
        new Chart(valCtx, {
            type: 'doughnut',
            data: {
                labels: ['Medicines', 'Medical Equipment', 'Consumables'],
                datasets: [{
                    data: [420000, 1500000, 240000],
                    backgroundColor: ['#0f6fff', '#8b5cf6', '#14b8a6']
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
