@extends('layouts.doctor', ['title' => 'My Patients Registry'])

@section('content')
<div class="patients-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Patient Directory</h2>
            
            <form action="{{ route('doctor.patients') }}" method="GET" class="search-form">
                <div class="search-box">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name...">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-search"></i> Search</button>
                </div>
            </form>
        </div>

        <div class="table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Patient Code</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Actions</th>
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
                            <td>
                                <a href="{{ route('doctor.patient.show', $patient->id) }}" class="btn btn-soft btn-sm">
                                    <i class="fa-solid fa-folder-open"></i> Open EMR Profile
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">No patients matching filters found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
            {{ $patients->links() }}
        </div>
    </div>
</div>

<style>
    .search-form {
        display: flex;
        gap: 12px;
    }

    .search-box {
        display: flex;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        background-color: var(--bg-primary);
    }

    .search-box input {
        border: none;
        padding: 8px 14px;
        font-family: inherit;
        background: transparent;
        color: var(--text-main);
        outline: none;
    }

    .search-box button {
        border-radius: 0;
        padding: 8px 16px;
    }
</style>
@endsection
