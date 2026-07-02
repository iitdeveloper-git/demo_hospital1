@extends('layouts.er', ['title' => 'ICU Critical Care Dashboard'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>ICU Patient Vital Monitors</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Trauma Case Ref</th>
                    <th>Bed Allocation</th>
                    <th>Medication / Notes</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $ip)
                    <tr>
                        <td>
                            <strong>{{ $ip->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $ip->patient->patient_code }}</span>
                        </td>
                        <td><code>{{ $ip->emergencyCase->case_number }}</code></td>
                        <td><strong>Bed {{ $ip->bed->bed_number }}</strong> ({{ $ip->bed->ward->name }})</td>
                        <td>
                            <span style="font-size:12px; color:var(--text-muted);">Ventilator connected. Vitals monitored.</span>
                        </td>
                        <td><span class="status-pill status-{{ $ip->status }}">{{ strtoupper($ip->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No patients admitted in ICU wards.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $patients->links() }}
    </div>
</div>
@endsection
