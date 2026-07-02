@extends('layouts.reception', ['title' => 'Patients Registry'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Registered Outpatients</h2>
        <form action="{{ route('reception.patients') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ID or Name..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
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
                    <th>Emergency Phone</th>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No registered patients found.</td>
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
