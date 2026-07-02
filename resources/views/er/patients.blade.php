@extends('layouts.er', ['title' => 'ER Patient Queue'])

@section('content')
<div class="patients-wrap">
    <div class="split-layout">
        <!-- Left: Register Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>File Trauma Admission</h2>
            </div>
            
            <form action="{{ url('er/patients') }}" method="POST" class="er-form">
                @csrf
                
                <div class="form-group">
                    <label for="patient_id">Patient ID Reference (Optional)</label>
                    <select id="patient_id" name="patient_id">
                        <option value="">Unknown / Jane Doe / John Doe</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="arrival_method">Arrival Mode</label>
                    <select id="arrival_method" name="arrival_method" required>
                        <option value="walk-in">Self Walk-In</option>
                        <option value="ambulance">Ambulance Dispatch</option>
                        <option value="helicopter">Critical Care Heli Transport</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority_level">Trauma Triage Priority</label>
                    <select id="priority_level" name="priority_level" required>
                        <option value="red">Level Red - STAT Immediate Resuscitation</option>
                        <option value="orange">Level Orange - Emergent</option>
                        <option value="yellow">Level Yellow - Urgent</option>
                        <option value="green">Level Green - Non-Urgent</option>
                        <option value="black">Level Black - Deceased/Expectant</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-truck-medical"></i> Register Emergency Case</button>
            </form>
        </div>

        <!-- Right: Queue Table -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>ER Admissions Queue</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Patient Name</th>
                            <th>Arrival Mode</th>
                            <th>Priority Class</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cases as $case)
                            <tr>
                                <td><code>{{ $case->case_number }}</code></td>
                                <td><strong>{{ $case->patient ? $case->patient->user->name : 'Unknown Patient (John/Jane Doe)' }}</strong></td>
                                <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $case->arrival_method }}</span></td>
                                <td><span class="status-pill status-{{ $case->priority_level }}">{{ strtoupper($case->priority_level) }}</span></td>
                                <td><span class="status-pill status-{{ $case->status }}">{{ ucfirst($case->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No patients in ER queue.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $cases->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 32px;
        align-items: start;
    }

    .er-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .er-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .er-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .er-form select {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .er-form select:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
