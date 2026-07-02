@extends('layouts.ai', ['title' => 'Drug Contraindication Checker'])

@section('content')
<div class="glass-panel">
    <div style="display:grid; grid-template-columns: 0.9fr 1.1fr; gap:32px; align-items:start;">
        <!-- Left: Form -->
        <div>
            <h2>Select Medicines to Audit</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Audit potential interaction risks between co-prescribed pharmaceutical agents.</p>

            <form action="{{ route('ai.drug-interactions.post') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <div>
                    <label for="drug_a">Attending Agent A</label>
                    <select name="drug_a" id="drug_a" required>
                        <option value="">Select Drug A</option>
                        <option value="Warfarin" {{ isset($drugA) && $drugA === 'Warfarin' ? 'selected' : '' }}>Warfarin</option>
                        <option value="Aspirin" {{ isset($drugA) && $drugA === 'Aspirin' ? 'selected' : '' }}>Aspirin</option>
                        <option value="Metformin" {{ isset($drugA) && $drugA === 'Metformin' ? 'selected' : '' }}>Metformin</option>
                        <option value="Lisinopril" {{ isset($drugA) && $drugA === 'Lisinopril' ? 'selected' : '' }}>Lisinopril</option>
                        <option value="Simvastatin" {{ isset($drugA) && $drugA === 'Simvastatin' ? 'selected' : '' }}>Simvastatin</option>
                        <option value="Amlodipine" {{ isset($drugA) && $drugA === 'Amlodipine' ? 'selected' : '' }}>Amlodipine</option>
                    </select>
                </div>

                <div>
                    <label for="drug_b">Attending Agent B</label>
                    <select name="drug_b" id="drug_b" required>
                        <option value="">Select Drug B</option>
                        <option value="Aspirin" {{ isset($drugB) && $drugB === 'Aspirin' ? 'selected' : '' }}>Aspirin</option>
                        <option value="Warfarin" {{ isset($drugB) && $drugB === 'Warfarin' ? 'selected' : '' }}>Warfarin</option>
                        <option value="Contrast Media" {{ isset($drugB) && $drugB === 'Contrast Media' ? 'selected' : '' }}>Contrast Media</option>
                        <option value="Spironolactone" {{ isset($drugB) && $drugB === 'Spironolactone' ? 'selected' : '' }}>Spironolactone</option>
                        <option value="Amlodipine" {{ isset($drugB) && $drugB === 'Amlodipine' ? 'selected' : '' }}>Amlodipine</option>
                    </select>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fa-solid fa-capsules"></i> Audit Interactions</button>
                </div>
            </form>
        </div>

        <!-- Right: Results -->
        <div style="border-left:1px solid var(--glass-border); padding-left:32px; min-height:360px; display:flex; flex-direction:column;">
            <h2>Co-Pilot Audit Output</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Contraindication logs are advisory only. Attending physician holds final decisions.</p>

            @if(isset($analysis))
                <div class="glass-panel" style="background:rgba(239, 68, 68, 0.03); border-color:rgba(239, 68, 68, 0.2); padding:20px; flex:1; line-height:1.75; font-size:14px; margin-bottom:20px;">
                    <strong style="color:{{ $severity === 'major' ? '#ef4444' : '#f59e0b' }}; display:block; margin-bottom:8px; font-size:15px; text-transform:uppercase;">
                        <i class="fa-solid fa-shield-virus"></i> Severity: {{ $severity }}
                    </strong>
                    {!! nl2br(e($analysis)) !!}
                </div>
            @else
                <div style="margin:auto; text-align:center; max-width:320px; color:var(--text-muted);">
                    <i class="fa-solid fa-capsules" style="font-size:48px; color:var(--glass-border); margin-bottom:16px;"></i>
                    <p>Select medicines and run the audit to preview contraindication warnings.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
