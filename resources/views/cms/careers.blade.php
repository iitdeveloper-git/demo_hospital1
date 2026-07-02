@extends('layouts.cms', ['title' => 'Careers Portal'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Job Vacancies & Openings</h2>
        <button class="btn btn-primary" onclick="alert('Opening job listing form...')"><i class="fa-solid fa-plus"></i> Post Vacancy</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Department</th>
                    <th>Location</th>
                    <th>Applications Received</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                    <tr>
                        <td><strong>{{ $job->title }}</strong></td>
                        <td>{{ $job->department }}</td>
                        <td>{{ $job->location }}</td>
                        <td>
                            <span class="pill" style="font-weight:700;">{{ $job->applications_count }} Candidates</span>
                        </td>
                        <td>
                            <span class="status-pill {{ $job->is_active ? 'status-paid' : 'status-pending' }}">
                                {{ $job->is_active ? 'ACTIVE' : 'CLOSED' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No job vacancies posted.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $jobs->links() }}
    </div>
</div>
@endsection
