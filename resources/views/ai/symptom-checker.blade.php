@extends('layouts.ai', ['title' => 'Clinical Symptom Triage Desk'])

@section('content')
<div class="glass-panel">
    <div style="display:grid; grid-template-columns: 0.9fr 1.1fr; gap:32px; align-items:start;">
        <!-- Left Side: Symptoms Triage Form -->
        <div>
            <h2>Triage Parameter Collection</h2>
            <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:20px;">Provide detailed patient metrics to compile preliminary triage conditions.</p>

            <form action="{{ route('ai.symptom-checker.post') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" value="34" required>
                    </div>
                    <div>
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female" selected>Female</option>
                            <option value="Non-Binary">Non-Binary</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="symptoms">Active Symptoms</label>
                    <textarea name="symptoms" id="symptoms" rows="3" placeholder="E.g., persistent dry cough, chest tightness, high body temperature..." required>persistent dry cough and mild chest tightness</textarea>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label for="duration_days">Duration (Days)</label>
                        <input type="number" name="duration_days" id="duration_days" value="5" required>
                    </div>
                    <div>
                        <label for="severity">Severity Level</label>
                        <select name="severity" id="severity" required>
                            <option value="low">Low</option>
                            <option value="medium" selected>Medium / Moderate</option>
                            <option value="high">High / Severe</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="medical_history">Medical History / Comorbidities</label>
                    <textarea name="medical_history" id="medical_history" rows="2" placeholder="E.g. hypertension, asthma, penicillin allergies...">mild asthma diagnosed in childhood</textarea>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fa-solid fa-stethoscope"></i> Execute Triage Check</button>
                </div>
            </form>
        </div>

        <!-- Right Side: Preliminary Diagnostic Guidance -->
        <div style="border-left:1px solid var(--glass-border); padding-left:32px; min-height:420px; display:flex; flex-direction:column;">
            <h2>AI Co-Pilot Advisory Outputs</h2>
            <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:20px;">Triage evaluation is not a diagnosis. Independent confirmation is required.</p>

            @if(isset($aiResponse))
                <div class="glass-panel" style="background:rgba(15,111,255,0.03); border-color:#0f6fff40; padding:20px; flex:1; line-height:1.75; font-size:14px; margin-bottom:20px;">
                    {!! nl2br(e($aiResponse)) !!}
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:14px; border-radius:10px;">
                        <span style="font-size:11px; color:var(--text-muted); font-weight:700;">SUGGESTED DEPT</span>
                        <strong style="display:block; font-size:16px; margin-top:4px; color:#0f6fff;">{{ $assessment->suggested_department }}</strong>
                    </div>
                    <div style="border:1px solid var(--glass-border); background:var(--bg-card); padding:14px; border-radius:10px;">
                        <span style="font-size:11px; color:var(--text-muted); font-weight:700;">URGENCY METRIC</span>
                        <strong style="display:block; font-size:16px; margin-top:4px; color:{{ $assessment->urgency_level === 'emergency' ? '#ef4444' : '#f59e0b' }};">
                            {{ strtoupper($assessment->urgency_level) }}
                        </strong>
                    </div>
                </div>
            @else
                <div style="margin:auto; text-align:center; max-width:320px; color:var(--text-muted);">
                    <i class="fa-solid fa-notes-medical" style="font-size:48px; color:var(--glass-border); margin-bottom:16px;"></i>
                    <p>Enter triage parameters on the left and execute the check to preview advisor recommendations.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
