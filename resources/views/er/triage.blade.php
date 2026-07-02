@extends('layouts.er', ['title' => 'Triage Board'])

@section('content')
<div class="triage-wrap">
    <div class="split-layout">
        <!-- Left: Vital Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Record Triage Vitals</h2>
            </div>
            
            <form action="{{ url('er/triage') }}" method="POST" class="triage-form">
                @csrf
                
                <div class="form-group">
                    <label for="triage_id">Active Triage Cases</label>
                    <select id="triage_id" name="triage_id" required>
                        <option value="">Select Case</option>
                        @foreach($assessments as $ta)
                            <option value="{{ $ta->id }}">{{ $ta->emergencyCase->case_number }} - {{ $ta->emergencyCase->patient ? $ta->emergencyCase->patient->user->name : 'Unknown' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="heart_rate">Heart Rate (BPM)</label>
                    <input type="number" id="heart_rate" name="heart_rate" required>
                </div>

                <div class="form-group">
                    <label for="blood_pressure">Blood Pressure (mmHg)</label>
                    <input type="text" id="blood_pressure" name="blood_pressure" placeholder="E.g. 120/80" required>
                </div>

                <div class="form-group">
                    <label for="temperature">Temperature (°C)</label>
                    <input type="number" id="temperature" name="temperature" step="0.1" required>
                </div>

                <div class="form-group">
                    <label for="oxygen_saturation">Oxygen Saturation SpO2 (%)</label>
                    <input type="number" id="oxygen_saturation" name="oxygen_saturation" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-heart-pulse"></i> Save Vitals</button>
            </form>
        </div>

        <!-- Right: Board -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Triage Vital Status Board</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Case ID</th>
                            <th>Patient Name</th>
                            <th>Vitals</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessments as $ta)
                            <tr>
                                <td><code>{{ $ta->emergencyCase->case_number }}</code></td>
                                <td><strong>{{ $ta->emergencyCase->patient ? $ta->emergencyCase->patient->user->name : 'Unknown Patient' }}</strong></td>
                                <td style="font-size:12px; line-height:1.4;">
                                    Pulse: <strong>{{ $ta->heart_rate ?? '--' }} BPM</strong><br>
                                    BP: <strong>{{ $ta->blood_pressure ?? '--' }}</strong><br>
                                    Temp: <strong>{{ $ta->temperature ?? '--' }} °C</strong><br>
                                    SpO2: <strong>{{ $ta->oxygen_saturation ?? '--' }}%</strong>
                                </td>
                                <td><span class="status-pill status-{{ $ta->status }}">{{ strtoupper($ta->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No triage cases registered.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $assessments->links() }}
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

    .triage-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .triage-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .triage-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .triage-form select,
    .triage-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .triage-form select:focus,
    .triage-form input:focus {
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
