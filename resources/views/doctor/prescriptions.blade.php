@extends('layouts.doctor', ['title' => 'Clinical Prescriptions'])

@section('content')
<div class="prescriptions-wrap">
    <div class="split-layout">
        <!-- Left: Draft Prescription Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Create Prescription</h2>
            </div>
            
            <form action="{{ route('doctor.prescriptions.store') }}" method="POST" class="rx-form">
                @csrf
                <div class="form-group">
                    <label for="patient_id">Patient</label>
                    <select id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="medication_name">Medicine Name</label>
                    <input type="text" id="medication_name" name="medication_name" placeholder="e.g. Amoxicillin 500mg" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dosage">Dosage</label>
                        <input type="text" id="dosage" name="dosage" placeholder="e.g. 1 tablet" required>
                    </div>
                    <div class="form-group">
                        <label for="frequency">Frequency</label>
                        <input type="text" id="frequency" name="frequency" placeholder="e.g. Twice a day" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration">Duration</label>
                        <input type="text" id="duration" name="duration" placeholder="e.g. 7 days" required>
                    </div>
                    <div class="form-group">
                        <label for="follow_up_date">Follow-up Date</label>
                        <input type="date" id="follow_up_date" name="follow_up_date">
                    </div>
                </div>

                <div class="form-group">
                    <label for="diagnosis">Diagnosis</label>
                    <input type="text" id="diagnosis" name="diagnosis" placeholder="Primary diagnosis...">
                </div>

                <div class="form-group">
                    <label for="instructions">Instructions</label>
                    <textarea id="instructions" name="instructions" rows="2" placeholder="Take after meals..."></textarea>
                </div>

                <div class="form-group">
                    <label for="advice">Clinical Advice</label>
                    <textarea id="advice" name="advice" rows="2" placeholder="Avoid heavy exercise..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-file-signature"></i> Sign & Issue Prescription</button>
            </form>
        </div>

        <!-- Right: Recent Issued Prescriptions -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Issued Prescriptions Log</h2>
            </div>
            
            <div class="rx-log-list">
                @forelse($prescriptions as $rx)
                    <div class="rx-log-card">
                        <div class="rx-log-header">
                            <strong>{{ $rx->patient->user->name }}</strong>
                            <span class="rx-date">{{ \Carbon\Carbon::parse($rx->issued_at)->format('M d, Y') }}</span>
                        </div>
                        <div class="rx-log-body">
                            <p><strong>{{ $rx->medication_name }}</strong> ({{ $rx->dosage }})</p>
                            <p class="meta">{{ $rx->frequency }} | {{ $rx->duration }}</p>
                            @if($rx->diagnosis)
                                <p class="dx">Diagnosis: {{ $rx->diagnosis }}</p>
                            @endif
                        </div>
                        <div class="rx-log-footer">
                            <button class="btn btn-secondary btn-sm" onclick="alert('Digital Prescription:\n\nPatient: {{ $rx->patient->user->name }}\nMedication: {{ $rx->medication_name }}\nDosage: {{ $rx->dosage }}\nFrequency: {{ $rx->frequency }}\nDuration: {{ $rx->duration }}\nDiagnosis: {{ $rx->diagnosis ?? \'N/A\' }}\n\n{{ $rx->digital_signature }}')">
                                <i class="fa-solid fa-print"></i> Print PDF
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="empty-state">No prescriptions issued yet.</p>
                @endforelse
            </div>
            
            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $prescriptions->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .rx-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .rx-form select,
    .rx-form input,
    .rx-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .rx-form select:focus,
    .rx-form input:focus,
    .rx-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    /* Log card list */
    .rx-log-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .rx-log-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 16px;
    }

    .rx-log-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .rx-date {
        font-size: 11px;
        color: var(--text-muted);
    }

    .rx-log-body p {
        margin: 0 0 6px;
        font-size: 13px;
    }

    .rx-log-body .meta {
        color: var(--text-muted);
        font-weight: 500;
    }

    .rx-log-body .dx {
        background-color: var(--bg-card);
        padding: 6px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid var(--border-color);
    }

    .rx-log-footer {
        border-top: 1px solid var(--border-color);
        padding-top: 10px;
        margin-top: 10px;
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
