@extends('layouts.reception', ['title' => 'Live Waiting Queue'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Live Tokens & Waiting Queue</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Token ID</th>
                    <th>Patient Name</th>
                    <th>Clinical Dept</th>
                    <th>Assigned Doctor</th>
                    <th>Priority</th>
                    <th>Est. Waiting Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tokens as $token)
                    <tr>
                        <td><strong style="color:var(--brand-primary); font-size:16px;">{{ $token->token_number }}</strong></td>
                        <td><strong>{{ $token->patient->user->name }}</strong></td>
                        <td>{{ $token->department->name }}</td>
                        <td>{{ $token->doctor->full_name }}</td>
                        <td><span class="badge" style="background-color:var(--bg-primary); border:1px solid var(--border-color); color:var(--text-muted); font-size:10px; font-weight:700;">{{ strtoupper($token->priority) }}</span></td>
                        <td>{{ $token->estimated_waiting_time }} mins</td>
                        <td><span class="status-pill status-{{ $token->status }}">{{ ucfirst($token->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-state">No patients in queue currently.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $tokens->links() }}
    </div>
</div>
@endsection
