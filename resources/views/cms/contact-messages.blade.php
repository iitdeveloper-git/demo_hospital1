@extends('layouts.cms', ['title' => 'Contact Forms Inbox'])

@section('content')
<div class="glass-panel">
    <h2>Public Contact Form Submissions</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Inbox logs of patient queries submitted online.</p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Sender Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date Received</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $msg)
                    <tr>
                        <td><strong>{{ $msg->name }}</strong></td>
                        <td>{{ $msg->email }}</td>
                        <td>
                            <strong>{{ $msg->subject }}</strong>
                            <p style="margin:4px 0 0; font-size:12px; color:var(--text-muted); max-width:400px;">{{ $msg->message }}</p>
                        </td>
                        <td>{{ $msg->created_at }}</td>
                        <td>
                            <span class="status-pill {{ $msg->status === 'read' ? 'status-paid' : 'status-cancelled' }}">
                                {{ strtoupper($msg->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No contact form messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $messages->links() }}
    </div>
</div>
@endsection
