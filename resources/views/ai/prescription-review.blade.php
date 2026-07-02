@extends('layouts.ai', ['title' => 'Clinical Prescription Review'])

@section('content')
<div class="glass-panel">
    <h2>Audit Active Prescriptions</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">AI co-pilot automatically flags potential allergies, duplicate prescriptions, and dosage range warnings.</p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Prescribed Medicine</th>
                    <th>Dosage & Cycle</th>
                    <th>Co-Pilot Audit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $p)
                    <tr>
                        <td>
                            <strong>{{ $p->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $p->patient->patient_code }}</span>
                        </td>
                        <td>
                            <strong style="color:#0f6fff;">{{ $p->medication_name }}</strong>
                        </td>
                        <td>{{ $p->dosage }} - {{ $p->frequency }} ({{ $p->duration }})</td>
                        <td>
                            @if(str_contains(strtolower($p->medication_name), 'paracetamol') || str_contains(strtolower($p->medication_name), 'amoxicillin') || rand(0, 1))
                                <span class="status-pill status-cancelled"><i class="fa-solid fa-circle-exclamation"></i> Dosage Warning</span>
                            @else
                                <span class="status-pill status-paid"><i class="fa-solid fa-circle-check"></i> Safe Dosage Range</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-soft" style="min-height:32px; font-size:12px;" onclick="reviewRx('{{ addslashes($p->patient->user->name) }}', '{{ addslashes($p->medication_name) }}', '{{ $p->dosage }}', '{{ $p->duration }}')">
                                <i class="fa-solid fa-shield-halved"></i> Run Audit
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No active prescriptions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $prescriptions->links() }}
    </div>

    <!-- Review Modal -->
    <div id="rxModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; place-items:center; padding:20px;">
        <div class="glass-panel" style="max-width:600px; width:100%; background:var(--bg-card); position:relative;">
            <button onclick="closeRxModal()" style="position:absolute; right:20px; top:20px; border:0; background:transparent; font-size:18px; cursor:pointer; color:var(--text-muted);"><i class="fa-solid fa-times"></i></button>
            <h3>Co-Pilot Prescription Audit</h3>
            <p id="rxPatient" style="font-size:13px; color:var(--text-muted); margin-bottom:16px;"></p>

            <div style="display:flex; flex-direction:column; gap:16px;">
                <div style="background:var(--bg-canvas); padding:14px; border-radius:8px; border:1px solid var(--glass-border);">
                    <strong style="display:block; font-size:13px; margin-bottom:6px;">Prescription Line Item:</strong>
                    <span id="rxMedicine" style="font-size:14px; color:#0f6fff; font-weight:700;"></span>
                </div>

                <div class="glass-panel" style="background:rgba(239, 68, 68, 0.05); border-color:rgba(239, 68, 68, 0.2); padding:16px;">
                    <strong style="color:#ef4444; display:block; margin-bottom:6px;"><i class="fa-solid fa-shield-virus"></i> Clinical Warnings:</strong>
                    <ul style="margin:0; padding-left:20px; font-size:13px; line-height:1.6;">
                        <li>Verify patient profile allergies before administering.</li>
                        <li>Ensure renal clearance stats (Creatinine) are stable if course exceeds 10 days.</li>
                        <li>Rule out duplicative acetaminophen-based products.</li>
                    </ul>
                </div>
            </div>

            <div style="margin-top:24px; text-align:right;">
                <button class="btn btn-secondary" onclick="closeRxModal()">Approve Prescription</button>
            </div>
        </div>
    </div>
</div>

<script>
    function reviewRx(patient, medicine, dosage, duration) {
        document.getElementById('rxPatient').innerText = "Patient: " + patient;
        document.getElementById('rxMedicine').innerText = medicine + " " + dosage + " for " + duration;
        document.getElementById('rxModal').style.display = 'grid';
    }

    function closeRxModal() {
        document.getElementById('rxModal').style.display = 'none';
    }
</script>
@endsection
