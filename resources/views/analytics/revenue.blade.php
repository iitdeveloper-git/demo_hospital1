@extends('layouts.analytics', ['title' => 'Revenue & Cash Flow Analytics'])

@section('content')
<div class="glass-panel">
    <h2>Financial Performance Ledger</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Monthly cash flow snapshots and operating expense ratios logged over time.</p>

    <!-- Chart Split -->
    <div style="display:grid; grid-template-columns: 1.3fr 0.7fr; gap:24px; margin-bottom:32px; align-items:start;">
        <!-- Left: Revenue trends chart -->
        <div class="glass-panel">
            <h3>Yearly Cashflow Trends</h3>
            <div style="height:300px; position:relative;">
                <canvas id="revChart"></canvas>
            </div>
        </div>

        <!-- Right: Fast Indicators -->
        <div class="glass-panel" style="display:flex; flex-direction:column; gap:16px;">
            <h3>Quick Indicators</h3>
            <div style="padding:14px; border:1px solid var(--glass-border); border-radius:10px;">
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">TOTAL INSURANCE OUTSTANDING</span>
                <strong style="display:block; font-size:20px; color:#ef4444; margin-top:4px;">₹14.28 Lakh</strong>
            </div>
            <div style="padding:14px; border:1px solid var(--glass-border); border-radius:10px;">
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">PHARMACY NET PROFIT RANGE</span>
                <strong style="display:block; font-size:20px; color:#10b981; margin-top:4px;">₹8.45 Lakh</strong>
            </div>
        </div>
    </div>

    <!-- Snapshots Table -->
    <h3>Snapshot History</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Snapshot Date</th>
                    <th>OPD Patients</th>
                    <th>IPD Admissions</th>
                    <th>Expenses Logged</th>
                    <th>Calculated Revenue</th>
                </tr>
            </thead>
            <tbody>
                @forelse($snapshots as $s)
                    <tr>
                        <td><strong>{{ $s->snapshot_date->toDateString() }}</strong></td>
                        <td>{{ $s->metrics_json['opd_count'] ?? 0 }}</td>
                        <td>{{ $s->metrics_json['ipd_count'] ?? 0 }}</td>
                        <td>₹{{ number_format($s->metrics_json['expenses'] ?? 0) }}</td>
                        <td style="color:#10b981; font-weight:700;">
                            ₹{{ number_format($s->metrics_json['total_revenue'] ?? 0) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No historical snapshot data recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($snapshots->pluck('snapshot_date')->map(fn($d) => $d->format('M Y'))->reverse()) !!},
                datasets: [{
                    label: 'Snapshot Revenue (₹)',
                    data: {!! json_encode($snapshots->pluck('metrics_json.total_revenue')->reverse()) !!},
                    borderColor: '#0f6fff',
                    backgroundColor: 'rgba(15, 111, 255, 0.08)',
                    fill: true,
                    tension: 0.4
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
