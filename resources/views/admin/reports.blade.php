@extends('layouts.admin', ['title' => 'Diagnostic Reports Database'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Clinical Lab & Radiology Reports</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Report Title</th>
                    <th>Type</th>
                    <th>Summary findings</th>
                    <th>Signing Clinician</th>
                    <th>Status</th>
                    <th>Date Published</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td><strong>{{ $report->patient->user->name }}</strong></td>
                        <td><strong>{{ $report->title }}</strong></td>
                        <td><span style="font-size:11px; font-weight:700; text-transform:uppercase;">{{ $report->report_type }}</span></td>
                        <td>{{ Str::limit($report->summary, 80) }}</td>
                        <td>{{ $report->doctor->full_name }}</td>
                        <td><span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                        <td>{{ \Carbon\Carbon::parse($report->reported_at)->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No clinical reports recorded in the database.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $reports->links() }}
    </div>
</div>
@endsection
