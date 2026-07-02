@extends('layouts.doctor', ['title' => 'Patient EMR File'])

@section('content')
<div class="emr-wrap">
    <div class="emr-grid">
        <!-- Left Column: Patient Profile & Vitals Log Form -->
        <div class="emr-left">
            <!-- Patient Banner Card -->
            <div class="panel patient-banner">
                <div class="banner-avatar">
                    <span>{{ substr($patient->user->name, 0, 2) }}</span>
                </div>
                <h2>{{ $patient->user->name }}</h2>
                <span class="patient-code"><i class="fa-solid fa-hashtag"></i> {{ $patient->patient_code }}</span>
                
                <div class="banner-details">
                    <div class="b-row"><span>DOB:</span> <strong>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</strong></div>
                    <div class="b-row"><span>Gender:</span> <strong>{{ ucfirst($patient->gender) }}</strong></div>
                    <div class="b-row"><span>Blood Group:</span> <strong style="color:#ef4444;">{{ $patient->blood_group ?? 'Not Specified' }}</strong></div>
                    <div class="b-row"><span>Emergency Phone:</span> <strong>{{ $patient->emergency_contact }}</strong></div>
                </div>
            </div>

            <!-- Vitals Log Form -->
            <div class="panel">
                <h3><i class="fa-solid fa-heart-pulse"></i> Record Patient Vitals</h3>
                <form action="{{ route('doctor.patient.vitals', $patient->id) }}" method="POST" class="vitals-form">
                    @csrf
                    <div class="form-grid-vitals">
                        <div class="form-group-vital">
                            <label for="blood_pressure">BP (mmHg)</label>
                            <input type="text" id="blood_pressure" name="blood_pressure" placeholder="120/80">
                        </div>
                        <div class="form-group-vital">
                            <label for="heart_rate">HR (bpm)</label>
                            <input type="number" id="heart_rate" name="heart_rate" placeholder="72">
                        </div>
                        <div class="form-group-vital">
                            <label for="temperature">Temp (°F)</label>
                            <input type="text" id="temperature" name="temperature" placeholder="98.6">
                        </div>
                        <div class="form-group-vital">
                            <label for="oxygen_level">SPO2 (%)</label>
                            <input type="number" id="oxygen_level" name="oxygen_level" placeholder="98">
                        </div>
                        <div class="form-group-vital">
                            <label for="blood_sugar">Glucose (mg/dL)</label>
                            <input type="number" id="blood_sugar" name="blood_sugar" placeholder="110">
                        </div>
                        <div class="form-group-vital">
                            <label for="weight">Weight (kg)</label>
                            <input type="text" id="weight" name="weight" placeholder="70">
                        </div>
                        <div class="form-group-vital">
                            <label for="height">Height (cm)</label>
                            <input type="text" id="height" name="height" placeholder="175">
                        </div>
                    </div>
                    <div class="form-group-vital" style="margin-top:16px;">
                        <label for="medical_notes">Clinical Notes</label>
                        <textarea id="medical_notes" name="medical_notes" rows="3" placeholder="Enter clinical assessment notes..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top:16px;"><i class="fa-solid fa-save"></i> Log Vitals</button>
                </form>
            </div>
        </div>

        <!-- Right Column: Medical History Logs -->
        <div class="emr-right">
            <!-- Vitals Log History -->
            <div class="panel">
                <h3>Vitals History</h3>
                <div class="table-wrap">
                    <table class="portal-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>BP</th>
                                <th>HR</th>
                                <th>SPO2</th>
                                <th>Temp</th>
                                <th>BMI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vitals as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->recorded_at)->format('M d, h:i A') }}</td>
                                    <td>{{ $record->blood_pressure ?? '-' }}</td>
                                    <td>{{ $record->heart_rate ? $record->heart_rate.' bpm' : '-' }}</td>
                                    <td>{{ $record->oxygen_level ? $record->oxygen_level.'%' : '-' }}</td>
                                    <td>{{ $record->temperature ? $record->temperature.'°F' : '-' }}</td>
                                    <td>{{ $record->bmi ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="empty-state">No vitals logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Active Prescriptions -->
            <div class="panel">
                <h3>Active Prescriptions</h3>
                <div class="rx-history-list">
                    @forelse($prescriptions as $rx)
                        <div class="rx-row">
                            <div class="rx-head">
                                <strong>{{ $rx->medication_name }}</strong>
                                <span class="rx-date">{{ \Carbon\Carbon::parse($rx->issued_at)->format('M d, Y') }}</span>
                            </div>
                            <p class="rx-meta">{{ $rx->dosage }} | {{ $rx->frequency }} | {{ $rx->duration }}</p>
                            @if($rx->instructions)
                                <p class="rx-notes">Directions: {{ $rx->instructions }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="empty-state">No prescriptions created for this patient.</p>
                    @endforelse
                </div>
            </div>

            <!-- Diagnostics Lab Reports -->
            <div class="panel">
                <h3>Diagnostic Lab Reports</h3>
                <div class="reports-history-list">
                    @forelse($reports as $report)
                        <div class="report-row">
                            <div class="report-head">
                                <strong>{{ $report->title }}</strong>
                                <span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                            </div>
                            <p class="report-date">{{ \Carbon\Carbon::parse($report->reported_at)->format('M d, Y') }}</p>
                            <p class="report-summary">{{ $report->summary }}</p>
                        </div>
                    @empty
                        <p class="empty-state">No diagnostic reports uploaded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .emr-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .patient-banner {
        text-align: center;
        padding: 32px 20px !important;
    }

    .banner-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background-color: var(--brand-soft);
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        font-size: 24px;
        font-weight: 700;
        border: 2px solid var(--border-color);
    }

    .patient-code {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        background-color: var(--bg-primary);
        padding: 4px 10px;
        border-radius: 99px;
        display: inline-block;
        margin-bottom: 20px;
    }

    .banner-details {
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
        border-top: 1px solid var(--border-color);
        padding-top: 16px;
    }

    .b-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }

    .b-row span {
        color: var(--text-muted);
    }

    .form-grid-vitals {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group-vital {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-group-vital label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .form-group-vital input,
    .form-group-vital textarea {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 13px;
        background: var(--bg-primary);
        color: var(--text-main);
    }

    .form-group-vital input:focus,
    .form-group-vital textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    /* History Lists */
    .rx-history-list, .reports-history-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 16px;
    }

    .rx-row, .report-row {
        padding: 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background-color: var(--bg-primary);
    }

    .rx-head, .report-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .rx-date, .report-date {
        font-size: 11px;
        color: var(--text-muted);
    }

    .rx-meta {
        font-size: 13px;
        font-weight: 600;
        margin: 0 0 6px;
    }

    .rx-notes, .report-summary {
        font-size: 12.5px;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.4;
    }

    @media (max-width: 992px) {
        .emr-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
