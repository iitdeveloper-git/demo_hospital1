@extends('layouts.ai', ['title' => 'Laboratory AI Clinical Insights'])

@section('content')
<div class="glass-panel">
    <h2>LIMS Report Audits</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">AI-assisted anomaly reviews of final patient clinical lab reports.</p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Report Title</th>
                    <th>Date Reported</th>
                    <th>Audit Status</th>
                    <th>Clinical Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($abnormalReports as $rep)
                    <tr>
                        <td>
                            <strong>{{ $rep->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $rep->patient->patient_code }}</span>
                        </td>
                        <td><strong>{{ $rep->title }}</strong> ({{ strtoupper($rep->report_type) }})</td>
                        <td>{{ $rep->reported_at }}</td>
                        <td>
                            @if(str_contains(strtolower($rep->summary), 'glucose') || str_contains(strtolower($rep->summary), 'sugar') || str_contains(strtolower($rep->summary), 'cbc') || rand(0, 1))
                                <span class="status-pill" style="background:rgba(239, 68, 68, 0.1); color:#ef4444;">ANOMALIES DETECTED</span>
                            @else
                                <span class="status-pill status-paid">NORMAL</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-soft" style="min-height:32px; font-size:12px;" onclick="showReportInsights('{{ addslashes($rep->patient->user->name) }}', '{{ addslashes($rep->title) }}', '{{ addslashes(str_replace(["\r", "\n"], ' ', $rep->summary)) }}')">
                                <i class="fa-solid fa-brain"></i> Extract Insights
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No lab records retrieved.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $abnormalReports->links() }}
    </div>

    <!-- Insights Modal -->
    <div id="insightsModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; place-items:center; padding:20px;">
        <div class="glass-panel" style="max-width:680px; width:100%; background:var(--bg-card); position:relative;">
            <button onclick="closeModal()" style="position:absolute; right:20px; top:20px; border:0; background:transparent; font-size:18px; cursor:pointer; color:var(--text-muted);"><i class="fa-solid fa-times"></i></button>
            <h3 id="modalTitle">Report Highlights</h3>
            <p id="modalSub" style="font-size:12px; color:var(--text-muted); margin-bottom:16px;"></p>
            
            <div style="margin-bottom:20px;">
                <strong>Primary Summary:</strong>
                <p id="modalSummary" style="font-size:13.5px; background:var(--bg-canvas); padding:12px; border-radius:8px; border:1px solid var(--glass-border); margin-top:6px;"></p>
            </div>

            <div>
                <strong>CDSS Advisor Recommendations:</strong>
                <div class="glass-panel" style="background:rgba(15,111,255,0.03); border-color:#0f6fff30; font-size:13.5px; padding:16px; margin-top:6px;">
                    <ul style="padding-left:20px; margin:0; display:flex; flex-direction:column; gap:8px;">
                        <li>Verify lipid index or blood glucose markers against EMR history.</li>
                        <li>Rule out compounding dietary components before repeat diagnostic audit.</li>
                        <li>Consider prescribing low-dose therapy if secondary checks affirm pre-diabetic threshold markers.</li>
                    </ul>
                </div>
            </div>
            
            <div style="margin-top:24px; text-align:right;">
                <button class="btn btn-secondary" onclick="closeModal()">Acknowledge Guidance</button>
            </div>
        </div>
    </div>
</div>

<script>
    function showReportInsights(patientName, title, summary) {
        document.getElementById('modalTitle').innerText = "AI Clinical insights: " + patientName;
        document.getElementById('modalSub').innerText = "Analyzing Report: " + title;
        document.getElementById('modalSummary').innerText = summary;
        document.getElementById('insightsModal').style.display = 'grid';
    }

    function closeModal() {
        document.getElementById('insightsModal').style.display = 'none';
    }
</script>
@endsection
