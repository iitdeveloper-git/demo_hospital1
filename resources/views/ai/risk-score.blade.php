@extends('layouts.ai', ['title' => 'Patient Risk Scoring Gauges'])

@section('content')
<div class="glass-panel">
    <div style="margin-bottom: 24px; display:flex; justify-content:space-between; align-items:center;">
        <form action="{{ route('ai.risk-score') }}" method="GET" style="display:flex; gap:16px; align-items:center;">
            <label for="patient_id" style="font-weight:700;">Select Patient:</label>
            <select name="patient_id" id="patient_id" onchange="this.form.submit()" style="max-width:320px;">
                @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ $selectedPatientId == $p->id ? 'selected' : '' }}>
                        {{ $p->user->name }} ({{ $p->patient_code }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if($selectedPatientId && count($riskScores) > 0)
        <!-- Grid layout for gauges -->
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:20px; margin-bottom:32px;">
            @foreach($riskScores->unique('risk_type') as $rs)
                <div class="glass-panel" style="text-align:center; position:relative; overflow:hidden;">
                    <span style="font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; display:block; margin-bottom:8px;">
                        {{ $rs->risk_type }} Risk
                    </span>
                    <strong style="font-size:42px; color:{{ $rs->score > 60 ? '#ef4444' : ($rs->score > 30 ? '#f59e0b' : '#10b981') }};">
                        {{ round($rs->score) }}%
                    </strong>
                    
                    <div style="margin-top:10px; font-size:12px; display:flex; align-items:center; justify-content:center; gap:6px;">
                        @if($rs->trend_direction === 'up')
                            <i class="fa-solid fa-arrow-trend-up" style="color:#ef4444;"></i> <span style="color:#ef4444; font-weight:700;">Rising</span>
                        @elseif($rs->trend_direction === 'down')
                            <i class="fa-solid fa-arrow-trend-down" style="color:#10b981;"></i> <span style="color:#10b981; font-weight:700;">Declining</span>
                        @else
                            <i class="fa-solid fa-arrows-left-right" style="color:var(--text-muted);"></i> <span>Stable</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Trend Chart -->
        <div class="glass-panel">
            <h2>Risk Trend Analysis</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Historical risk scoring fluctuations logged over time.</p>
            <div style="height:300px; position:relative;">
                <canvas id="riskTrendChart"></canvas>
            </div>
        </div>
    @else
        <p class="empty-state">No risk scores registered for this patient profile.</p>
    @endif
</div>

@if($selectedPatientId && count($riskScores) > 0)
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('riskTrendChart').getContext('2d');
        
        // Build mock chart inputs based on seeded risk assessment dates
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($riskScores->pluck('assessment_date')->map(fn($d) => $d->toDateString())) !!},
                datasets: [{
                    label: 'Calculated Risk Score (%)',
                    data: {!! json_encode($riskScores->pluck('score')) !!},
                    borderColor: '#14b8a6',
                    backgroundColor: 'rgba(20, 184, 166, 0.25)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { min: 0, max: 100 }
                }
            }
        });
    });
</script>
@endif
@endsection
