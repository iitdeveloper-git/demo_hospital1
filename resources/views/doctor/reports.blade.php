@extends('layouts.doctor', ['title' => 'Diagnostic Lab Reports'])

@section('content')
<div class="reports-wrap">
    <div class="split-layout">
        <!-- Left: Upload New Report Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Upload Lab Report</h2>
            </div>
            
            <form action="{{ route('doctor.reports.upload') }}" method="POST" class="report-form">
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
                    <label for="title">Report Title</label>
                    <input type="text" id="title" name="title" placeholder="e.g. CBC Blood Panel" required>
                </div>

                <div class="form-group">
                    <label for="report_type">Report Type</label>
                    <select id="report_type" name="report_type" required>
                        <option value="lab">Pathology Lab</option>
                        <option value="radiology">Radiology / Imaging</option>
                        <option value="clinical">Clinical assessment</option>
                        <option value="discharge">Discharge summary</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="summary">Summary Findings</label>
                    <textarea id="summary" name="summary" rows="4" placeholder="Enter diagnostic findings summary..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cloud-arrow-up"></i> Upload & Finalize Report</button>
            </form>
        </div>

        <!-- Right: Recent Reports & Approvals -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Diagnostic Reports & Sign-offs</h2>
            </div>

            <div class="reports-list">
                @forelse($reports as $report)
                    <div class="report-card-doc">
                        <div class="report-card-head">
                            <strong>{{ $report->patient->user->name }}</strong>
                            <span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                        </div>
                        <p class="report-title-meta"><strong>{{ $report->title }}</strong> ({{ strtoupper($report->report_type) }})</p>
                        <p class="summary-text">{{ $report->summary }}</p>
                        
                        @if($report->status === 'review')
                            <form action="{{ route('doctor.reports.approve', $report->id) }}" method="POST" class="approve-form">
                                @csrf
                                <input type="text" name="remarks" placeholder="Add clinical remarks..." required>
                                <button type="submit" class="btn btn-soft btn-sm"><i class="fa-solid fa-signature"></i> Approve</button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="empty-state">No diagnostic reports uploaded yet.</p>
                @endforelse
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .report-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .report-form select,
    .report-form input,
    .report-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .report-form select:focus,
    .report-form input:focus,
    .report-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    /* Reports List */
    .reports-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .report-card-doc {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 16px;
    }

    .report-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 8px;
        margin-bottom: 8px;
    }

    .report-title-meta {
        font-size: 13px;
        margin: 0 0 8px;
    }

    .summary-text {
        font-size: 12.5px;
        color: var(--text-muted);
        line-height: 1.5;
        margin: 0 0 12px;
    }

    .approve-form {
        display: flex;
        gap: 10px;
        border-top: 1px solid var(--border-color);
        padding-top: 12px;
    }

    .approve-form input {
        flex-grow: 1;
        padding: 6px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 12px;
        background-color: var(--bg-card);
        color: var(--text-main);
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
