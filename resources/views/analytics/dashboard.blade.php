@extends('layouts.analytics', ['title' => 'Executive Analytics Dashboard'])

@section('content')
<div class="dashboard-wrap">
    <!-- Quick Cards Grid -->
    <div class="stat-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:32px;">
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(15,111,255,0.1); color:#0f6fff;"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">MONTHLY REVENUE</span>
                <strong style="font-size:20px; display:block;">₹{{ number_format($metrics['total_revenue'] ?? 680000) }}</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(20,184,166,0.1); color:#14b8a6;"><i class="fa-solid fa-user-check"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">OPD DISPATCHES</span>
                <strong style="font-size:20px; display:block;">{{ $metrics['opd_count'] ?? 1120 }} Patients</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(139,92,246,0.1); color:#8b5cf6;"><i class="fa-solid fa-hospital-user"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">IPD ADMISSIONS</span>
                <strong style="font-size:20px; display:block;">{{ $metrics['ipd_count'] ?? 240 }} Patients</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(239,68,68,0.1); color:#ef4444;"><i class="fa-solid fa-calculator"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">MONTHLY LOSS / EXPENSE</span>
                <strong style="font-size:20px; display:block;">₹{{ number_format($metrics['expenses'] ?? 140000) }}</strong>
            </div>
        </div>
    </div>

    <!-- Active widgets & KPI progress lists -->
    <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:24px; align-items:start;">
        <!-- Left Column: Active Custom Widgets Grid (Vite + Chart.js draggable layouts ready) -->
        <div class="glass-panel" style="min-height:480px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                <h2>Executive Visual Indicators</h2>
                <span class="pill" style="font-size:10px;">Drag-n-Drop Custom Coordinates Saved</span>
            </div>
            
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;" id="widgets-container">
                @foreach($widgets as $w)
                    <div class="glass-panel" style="background:var(--bg-card); padding:16px; border-radius:12px; border:1px solid var(--glass-border); min-height:180px; cursor:move;" data-key="{{ $w->widget_key }}">
                        <strong style="font-size:13px; text-transform:uppercase; color:var(--text-muted); display:block; margin-bottom:12px;">
                            <i class="fa-solid fa-arrows-up-down-left-right"></i> {{ str_replace('_', ' ', $w->widget_key) }}
                        </strong>
                        
                        <!-- Simple visual indicator preview depending on widget type -->
                        @if($w->widget_key === 'revenue_card')
                            <div style="font-size:28px; color:#10b981; font-weight:800; margin-top:14px;">₹5.42 Cr</div>
                            <span style="font-size:11px; color:var(--text-muted);">Yearly Cumulative Cashflow</span>
                        @elseif($w->widget_key === 'patient_growth')
                            <div style="font-size:28px; color:#0f6fff; font-weight:800; margin-top:14px;">+18.4%</div>
                            <span style="font-size:11px; color:var(--text-muted);">OPD Traffic Growth Ratios</span>
                        @else
                            <div style="font-size:28px; color:#8b5cf6; font-weight:800; margin-top:14px;">84%</div>
                            <span style="font-size:11px; color:var(--text-muted);">Active Operating Capacity</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column: KPI targets achievement list -->
        <div class="glass-panel">
            <h2>KPI Target Progress Checks</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:24px;">Attending thresholds configured for current administrative cycle.</p>

            <div style="display:flex; flex-direction:column; gap:20px;">
                @foreach($kpis as $kp)
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; font-size:13px; margin-bottom:6px;">
                            <strong>{{ $kp->kpi_name }}</strong>
                            <strong style="color:#0f6fff;">{{ round($kp->achievement_percentage) }}%</strong>
                        </div>
                        <div style="width:100%; height:8px; background:var(--glass-border); border-radius:4px; overflow:hidden;">
                            <div style="width:{{ min(100, $kp->achievement_percentage) }}%; height:100%; background:var(--brand-gradient); border-radius:4px;"></div>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:10px; color:var(--text-muted); margin-top:4px;">
                            <span>Current: {{ number_format($kp->current_value) }}</span>
                            <span>Target: {{ number_format($kp->target_value) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        gsap.from("#widgets-container .glass-panel", {
            duration: 0.6,
            opacity: 0,
            y: 30,
            stagger: 0.1,
            ease: "power2.out"
        });
    });
</script>
@endsection
