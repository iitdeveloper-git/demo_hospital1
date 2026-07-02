@extends('layouts.admin', ['title' => 'Audit & Security Logs'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Security Audit Logs</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>User</th>
                    <th>Action Event</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>#{{ str_pad((string)$log->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $log->user?->name ?? 'Guest/Anonymous' }}</strong></td>
                        <td><code style="background-color:var(--bg-primary); padding:2px 6px; border-radius:4px;">{{ $log->action }}</code></td>
                        <td>{{ $log->ip_address }}</td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ Str::limit($log->user_agent, 60) }}</td>
                        <td>{{ $log->created_at->format('M d, Y - H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No audit activities logged in the database.</td>
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
