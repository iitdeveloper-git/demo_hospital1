@extends('layouts.admin', ['title' => 'Patients Registry Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Registered Patients</h2>
        <form action="{{ route('admin.patients') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patients..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient Code</th>
                    <th>Full Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Emergency Contact</th>
                    <th>Insurance Provider</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td><strong>{{ $patient->patient_code }}</strong></td>
                        <td><strong>{{ $patient->user->name }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</td>
                        <td>{{ ucfirst($patient->gender) }}</td>
                        <td><span style="color:#ef4444; font-weight:700;">{{ $patient->blood_group ?? '-' }}</span></td>
                        <td>{{ $patient->emergency_contact }}</td>
                        <td>{{ $patient->insurance_provider ?? 'Self-pay' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No patients registered.</td>
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
