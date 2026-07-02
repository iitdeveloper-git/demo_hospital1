@extends('layouts.laboratory', ['title' => 'Quality Control Calibrations'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Quality Control & Calibration Logs</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>QC Run ID</th>
                    <th>Equipment Analyzer</th>
                    <th>QC Procedure Name</th>
                    <th>Result Value</th>
                    <th>Checked Timestamp</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>#QC-{{ str_pad((string)$log->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $log->equipment->name }}</strong></td>
                        <td>{{ $log->qc_name }}</td>
                        <td><code style="background-color:var(--bg-primary); padding:2px 6px; border-radius:4px;">{{ $log->result }}</code></td>
                        <td>{{ \Carbon\Carbon::parse($log->checked_at)->format('M d, Y - H:i') }}</td>
                        <td><span class="status-pill status-{{ $log->status }}">{{ ucfirst($log->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No Quality Control logs recorded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
