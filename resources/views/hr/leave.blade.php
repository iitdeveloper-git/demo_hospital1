@extends('layouts.hr', ['title' => 'Leave Request Approvals'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Active Leave Applications</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Category</th>
                    <th>Reason / Notes</th>
                    <th>Status</th>
                    <th>Action Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $lr)
                    <tr>
                        <td>
                            <strong>{{ $lr->employee->full_name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $lr->employee->employee_code }}</span>
                        </td>
                        <td><span class="type-badge">{{ ucfirst($lr->leave_type) }} Leave</span></td>
                        <td style="font-size:12px; color:var(--text-muted);">{{ $lr->reason }}</td>
                        <td><span class="status-pill status-{{ $lr->status }}">{{ ucfirst($lr->status) }}</span></td>
                        <td>
                            @if($lr->status === 'pending')
                                <div style="display:flex; gap:8px;">
                                    <form action="{{ route('hr.leave.approve', $lr->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-check"></i> Approve</button>
                                    </form>
                                    <form action="{{ route('hr.leave.reject', $lr->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-times"></i> Reject</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No leave applications registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $requests->links() }}
    </div>
</div>

<style>
    .type-badge {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }
</style>
@endsection
