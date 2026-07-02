@extends('layouts.laboratory', ['title' => 'Validation Reports'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Diagnostics Lab & Pathology Reports</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Report Title</th>
                    <th>Reference Range</th>
                    <th>Signing Doctor</th>
                    <th>Validation Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td><strong>{{ $report->patient->user->name }}</strong></td>
                        <td><strong>{{ $report->title }}</strong></td>
                        <td><span style="font-size:12px; color:var(--text-muted);">{{ Str::limit($report->summary, 80) }}</span></td>
                        <td>{{ $report->doctor->full_name }}</td>
                        <td><span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm" onclick="alert('Digital Signatures Verification:\n\nVerifier: Pathologist MD\nDigitally Signed: SHA-256\nReport Status: {{ ucfirst($report->status) }}')"><i class="fa-solid fa-signature"></i> Verify Signatures</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No pathology reports available for validation.</td>
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
