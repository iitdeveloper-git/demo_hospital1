@extends('layouts.pharmacy', ['title' => 'Prescriptions Dispense Desk'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Doctor Prescriptions Desk</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Prescribed Medicine</th>
                    <th>Dosage & Frequency</th>
                    <th>Duration</th>
                    <th>Requesting Doctor</th>
                    <th>Date Issued</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prescriptions as $rx)
                    <tr>
                        <td>
                            <strong>{{ $rx->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $rx->patient->patient_code }}</span>
                        </td>
                        <td><strong>{{ $rx->medication_name }}</strong></td>
                        <td>{{ $rx->dosage }} | {{ $rx->frequency }}</td>
                        <td>{{ $rx->duration }}</td>
                        <td>{{ $rx->doctor->full_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($rx->issued_at)->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('pharmacy.prescriptions.dispense', $rx->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-file-prescription"></i> Dispense</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No doctor prescriptions issued today.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $prescriptions->links() }}
    </div>
</div>
@endsection
