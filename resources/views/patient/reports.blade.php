@extends('layouts.patient', ['title' => 'Lab & Radiology Reports'])

@section('content')
<div class="reports-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Diagnostic Reports</h2>
        </div>

        <div class="reports-grid">
            @forelse($reports as $report)
                <div class="report-card">
                    <div class="report-card-header">
                        <div class="report-icon-wrap">
                            <i class="fa-solid {{ $report->report_type === 'radiology' ? 'fa-x-ray' : 'fa-flask-vial' }}"></i>
                        </div>
                        <div>
                            <h3>{{ $report->title }}</h3>
                            <span class="report-date">{{ \Carbon\Carbon::parse($report->reported_at)->format('F j, Y') }}</span>
                        </div>
                        <span class="status-pill status-{{ $report->status }}">{{ ucfirst($report->status) }}</span>
                    </div>

                    <div class="report-card-body">
                        <p class="summary-text">{{ Str::limit($report->summary, 240) }}</p>
                        
                        <div class="report-meta">
                            <span><i class="fa-solid fa-user-doctor"></i> Prescribed by: <strong>{{ $report->doctor->full_name }}</strong></span>
                            <span><i class="fa-solid fa-hospital"></i> Department: {{ $report->doctor->department->name }}</span>
                        </div>
                    </div>

                    <div class="report-card-footer">
                        <button class="btn btn-secondary btn-sm" onclick="alert('Viewing: {{ $report->title }}\n\nFull Summary:\n{{ addslashes($report->summary) }}')">
                            <i class="fa-solid fa-eye"></i> View Summary
                        </button>
                        <button class="btn btn-soft btn-sm" onclick="alert('Downloading CSV/PDF for {{ $report->title }}')">
                            <i class="fa-solid fa-download"></i> Download PDF
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state-panel">
                    <i class="fa-solid fa-folder-open"></i>
                    <h3>No Diagnostic Reports</h3>
                    <p>No lab or radiology reports have been published on your clinical file yet.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-container">
            {{ $reports->links() }}
        </div>
    </div>
</div>

<style>
    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 16px;
    }

    .report-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 280px;
    }

    .report-card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 14px;
    }

    .report-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background-color: var(--brand-soft);
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .report-card-header h3 {
        margin: 0 0 2px;
        font-size: 15px;
        font-weight: 700;
    }

    .report-date {
        font-size: 11px;
        color: var(--text-muted);
    }

    .report-card-header .status-pill {
        position: absolute;
        top: 0;
        right: 0;
    }

    .report-card-body {
        padding: 14px 0;
        flex-grow: 1;
    }

    .summary-text {
        font-size: 13.5px;
        color: var(--text-main);
        line-height: 1.6;
        margin: 0 0 14px;
    }

    .report-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        font-size: 12px;
        color: var(--text-muted);
    }

    .report-meta i {
        width: 14px;
    }

    .report-card-footer {
        display: flex;
        gap: 10px;
        border-top: 1px solid var(--border-color);
        padding-top: 14px;
    }

    .btn-secondary {
        background-color: var(--bg-card);
        color: var(--text-main);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background-color: var(--bg-primary);
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .empty-state-panel {
        text-align: center;
        padding: 48px;
        color: var(--text-muted);
        grid-column: 1 / -1;
    }

    .empty-state-panel i {
        font-size: 40px;
        margin-bottom: 16px;
    }

    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }
</style>
@endsection
