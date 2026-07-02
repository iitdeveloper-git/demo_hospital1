@extends('layouts.reception', ['title' => 'Admission Desk'])

@section('content')
<div class="admissions-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Admit Patient</h2>
            </div>
            
            <form action="{{ route('reception.admissions.store') }}" method="POST" class="admission-form">
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
                    <label for="doctor_id">Admitting Doctor</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="ward_type">Ward Category</label>
                    <select id="ward_type" name="ward_type" required>
                        <option value="general">General Ward</option>
                        <option value="private">Private Room</option>
                        <option value="semi_private">Semi Private</option>
                        <option value="icu">ICU Bed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="bed_number">Bed Number</label>
                    <input type="text" id="bed_number" name="bed_number" placeholder="e.g. ICU-02" required>
                </div>

                <div class="form-group">
                    <label for="notes">Clinical Admission Notes</label>
                    <textarea id="notes" name="notes" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-bed"></i> Process Bed Admission</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Active Admissions Log</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Ward</th>
                            <th>Bed Number</th>
                            <th>Doctor</th>
                            <th>Admission Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions as $adm)
                            <tr>
                                <td><strong>{{ $adm->patient->user->name }}</strong></td>
                                <td><span style="font-weight:700; text-transform:uppercase; font-size:11px;">{{ $adm->ward_type }}</span></td>
                                <td><strong>{{ $adm->bed_number }}</strong></td>
                                <td>{{ $adm->doctor->full_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($adm->admission_date)->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No patients admitted in wards.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $admissions->links() }}
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

    .admission-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .admission-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .admission-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .admission-form select,
    .admission-form input,
    .admission-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .admission-form select:focus,
    .admission-form input:focus,
    .admission-form textarea:focus {
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
