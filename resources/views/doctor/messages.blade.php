@extends('layouts.doctor', ['title' => 'Secure Messaging'])

@section('content')
<div class="messages-wrap">
    <div class="split-layout">
        <!-- Left: Dispatch New Message -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>New Message</h2>
            </div>
            
            <form action="{{ route('doctor.messages.send') }}" method="POST" class="msg-form">
                @csrf
                <div class="form-group">
                    <label for="receiver_id">Recipient</label>
                    <select id="receiver_id" name="receiver_id" required>
                        <option value="">Select Recipient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->user->id }}">{{ $patient->user->name }} (Patient)</option>
                        @endforeach
                        <option value="1">Aarav Mehta (Admin)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="body">Message Body</label>
                    <textarea id="body" name="body" rows="5" placeholder="Type your secure message here..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
            </form>
        </div>

        <!-- Right: Message History -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Secure Inbox & Threads</h2>
            </div>
            
            <div class="msg-history-list">
                @forelse($messages as $msg)
                    <div class="msg-row {{ $msg->sender_id === Auth::user()->id ? 'sent' : 'received' }}">
                        <div class="msg-meta">
                            <strong>{{ $msg->sender_id === Auth::user()->id ? 'To: ' . $msg->receiver->name : 'From: ' . $msg->sender->name }}</strong>
                            <span class="msg-time">{{ \Carbon\Carbon::parse($msg->created_at)->diffForHumans() }}</span>
                        </div>
                        <p class="msg-body-text">{{ $msg->body }}</p>
                    </div>
                @empty
                    <p class="empty-state">No messages in secure inbox.</p>
                @endforelse
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

    .msg-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .msg-form select,
    .msg-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .msg-form select:focus,
    .msg-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    /* Message history inbox cards */
    .msg-history-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        max-height: 480px;
        overflow-y: auto;
    }

    .msg-row {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.4;
        max-width: 85%;
    }

    .msg-row.sent {
        background-color: var(--brand-soft);
        border: 1px solid rgba(2, 132, 199, 0.15);
        align-self: flex-end;
    }

    .msg-row.received {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        align-self: flex-start;
    }

    .msg-meta {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 6px;
    }

    .msg-time {
        color: var(--text-muted);
    }

    .msg-body-text {
        margin: 0;
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
