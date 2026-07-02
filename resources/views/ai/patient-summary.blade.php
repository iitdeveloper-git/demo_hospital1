@extends('layouts.ai', ['title' => 'Patient Synthesis Timeline'])

@section('content')
<div class="glass-panel">
    <div style="margin-bottom: 24px;">
        <form action="{{ route('ai.patient-summary') }}" method="GET" style="display:flex; gap:16px; align-items:center;">
            <label for="patient_id" style="font-weight:700;">Select Patient Profile:</label>
            <select name="patient_id" id="patient_id" onchange="this.form.submit()" style="max-width:320px;">
                @foreach($patients as $p)
                    <option value="{{ $p->id }}" {{ $selectedPatientId == $p->id ? 'selected' : '' }}>
                        {{ $p->user->name }} ({{ $p->patient_code }})
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if(!empty($summaryData))
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:32px;">
            <!-- Left: EMR Clinical Parameters -->
            <div>
                <h2>Clinical Health Record Indicators</h2>
                
                <!-- Vitals Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin:20px 0;">
                    <div style="border:1px solid var(--glass-border); padding:14px; border-radius:10px;">
                        <span style="font-size:11px; color:var(--text-muted); font-weight:700;">BLOOD GROUP</span>
                        <strong style="display:block; font-size:18px; margin-top:4px;">{{ $summaryData['patient']->blood_group ?? 'O+' }}</strong>
                    </div>
                    <div style="border:1px solid var(--glass-border); padding:14px; border-radius:10px;">
                        <span style="font-size:11px; color:var(--text-muted); font-weight:700;">INSURANCE</span>
                        <strong style="display:block; font-size:18px; margin-top:4px;">{{ $summaryData['patient']->insurance_provider ?? 'Self-Pay' }}</strong>
                    </div>
                </div>

                <h3>Active Allergies & Conditions</h3>
                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:24px;">
                    @forelse($summaryData['patient']->medical_alerts ?? ['No active medical warnings recorded.'] as $alert)
                        <span class="pill" style="background:rgba(239, 68, 68, 0.1); color:#ef4444; border:1px solid rgba(239, 68, 68, 0.15); font-weight:700;">{{ $alert }}</span>
                    @empty
                        <span class="pill">No alerts recorded</span>
                    @endforelse
                </div>

                <h3>Active Prescriptions</h3>
                <div class="table-wrap" style="margin-bottom:24px;">
                    <table>
                        <thead>
                            <tr>
                                <th>Medicine</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryData['prescriptions']->take(4) as $pr)
                                <tr>
                                    <td><strong>{{ $pr->medication_name }}</strong></td>
                                    <td>{{ $pr->dosage }} ({{ $pr->frequency }})</td>
                                    <td>{{ $pr->duration }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="empty-state">No current prescription records.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h3>Outstanding Billing Registry</h3>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($summaryData['bills']->take(3) as $bill)
                                <tr>
                                    <td><code>{{ $bill->invoice_number }}</code></td>
                                    <td>{{ $bill->due_at->toDateString() }}</td>
                                    <td><span class="status-pill status-{{ $bill->status }}">{{ strtoupper($bill->status) }}</span></td>
                                    <td><strong>₹{{ number_format($bill->amount) }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">No pending bills.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: AI Synthesised Summary Timeline -->
            <div style="border-left: 1px solid var(--glass-border); padding-left:32px;">
                <h2>Clinical Co-Pilot Synthesized Summary</h2>
                <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">AI summary updated dynamically based on EMR, labs, and history logs.</p>
                
                <div class="glass-panel" style="background:rgba(15,111,255,0.03); border-color:#0f6fff40; padding:20px; line-height:1.75; font-size:14.5px;">
                    {!! nl2br(e($summaryData['ai_summary'])) !!}
                </div>

                <div style="margin-top:24px;">
                    <h3>Emergency Contacts</h3>
                    <div style="background:var(--bg-card); padding:16px; border-radius:12px; border:1px solid var(--glass-border); display:flex; align-items:center; justify-content:space-between;">
                        <div>
                            <strong style="display:block;">{{ $summaryData['patient']->emergency_contact ?? 'Not Configured' }}</strong>
                            <small style="color:var(--text-muted);">Attending Primary Contact</small>
                        </div>
                        <a href="tel:{{ $summaryData['patient']->emergency_contact }}" class="btn btn-soft" style="min-height:36px; width:36px; padding:0; display:grid; place-items:center; border-radius:50%;"><i class="fa-solid fa-phone"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p class="empty-state">No patient data could be retrieved.</p>
    @endif
</div>
@endsection
