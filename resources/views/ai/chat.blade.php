@extends('layouts.ai', ['title' => 'AI Clinical Co-Pilot Chat'])

@section('content')
<style>
    .chat-layout {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
        height: 70vh;
        min-height: 520px;
    }

    .chat-sidebar {
        display: flex;
        flex-direction: column;
        gap: 16px;
        height: 100%;
        overflow-y: auto;
    }

    .conversation-card {
        padding: 14px;
        border-radius: 12px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        transition: all 0.2s ease;
    }

    .conversation-card.active-chat {
        border-color: #0f6fff;
        background: rgba(15, 111, 255, 0.05);
    }

    .chat-main {
        display: flex;
        flex-direction: column;
        height: 100%;
        border-radius: 16px;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .message-bubble {
        max-width: 80%;
        padding: 16px;
        border-radius: 14px;
        line-height: 1.6;
        font-size: 14.5px;
    }

    .message-bubble.user {
        align-self: flex-end;
        background: #0f6fff;
        color: #fff;
        border-bottom-right-radius: 2px;
    }

    .message-bubble.ai {
        align-self: flex-start;
        background: var(--bg-card);
        border: 1px solid var(--glass-border);
        border-bottom-left-radius: 2px;
    }

    .suggestion-chip {
        padding: 8px 14px;
        background: rgba(15, 111, 255, 0.08);
        border: 1px solid rgba(15, 111, 255, 0.15);
        color: #0f6fff;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .suggestion-chip:hover {
        background: #0f6fff;
        color: #fff;
    }
</style>

<div class="glass-panel chat-layout">
    <!-- Chat Sidebar History -->
    <div class="chat-sidebar">
        <a href="{{ route('ai.chat') }}" class="btn btn-primary" style="width: 100%;"><i class="fa-solid fa-plus"></i> New Consultation</a>
        
        <div style="position:relative; margin-bottom:10px;">
            <input type="text" id="chat-search" placeholder="Search chats..." style="padding-left:36px; font-size:13px;">
            <i class="fa-solid fa-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--text-muted);"></i>
        </div>

        <div style="display:flex; flex-direction:column; gap:10px;" id="conversations-list">
            @forelse($conversations as $c)
                <div class="conversation-card {{ $activeConversation && $activeConversation->id === $c->id ? 'active-chat' : '' }}" 
                     onclick="window.location.href='{{ route('ai.chat', ['conversation_id' => $c->id]) }}'">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <i class="fa-regular fa-comments" style="color:#0f6fff;"></i>
                        <div style="text-align:left;">
                            <strong style="display:block; font-size:13px; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $c->title }}</strong>
                            <small style="font-size:10px; color:var(--text-muted);">Role: {{ ucfirst($c->role) }}</small>
                        </div>
                    </div>
                    @if($c->is_pinned)
                        <i class="fa-solid fa-thumbtack" style="color:#ef4444; font-size:11px;"></i>
                    @endif
                </div>
            @empty
                <p style="text-align:center; color:var(--text-muted); font-size:13px; margin-top:20px;">No clinical chat history.</p>
            @endforelse
        </div>
    </div>

    <!-- Active Chat Window -->
    <div class="chat-main" style="background:var(--bg-canvas); border: 1px solid var(--glass-border);">
        <!-- Active Chat Header -->
        <div style="padding:14px 20px; border-bottom:1px solid var(--glass-border); display:flex; justify-content:space-between; align-items:center; background:var(--bg-card);">
            <div>
                <strong style="font-size:15px; display:block;">{{ $activeConversation->title ?? 'New Consultation Chat' }}</strong>
                <span class="pill" style="font-size:9px;">Active Engine: Gemini Advisory Mode</span>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="btn btn-soft" style="min-height:36px; padding:0 12px; font-size:12px;" onclick="copyConversation()"><i class="fa-solid fa-copy"></i> Copy Log</button>
                <button class="btn btn-soft" style="min-height:36px; padding:0 12px; font-size:12px;" onclick="exportChat()"><i class="fa-solid fa-file-export"></i> Export</button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="chat-messages" id="messages-container">
            @if($activeConversation)
                @foreach($activeConversation->messages as $msg)
                    <div class="message-bubble {{ $msg->sender_role }}">
                        <div style="font-size:11px; margin-bottom:6px; opacity:0.75; font-weight:700;">
                            {{ $msg->sender_role === 'user' ? 'USER / PRACTITIONER' : 'CDSS CO-PILOT ADVISOR' }}
                        </div>
                        <div>
                            {!! nl2br(e($msg->message_content)) !!}
                        </div>
                        @if($msg->sender_role === 'ai')
                            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px; border-top:1px solid var(--glass-border); padding-top:6px;">
                                <button class="icon-button" style="min-height:28px; width:28px; font-size:11px;" onclick="logFeedback({{ $msg->id }}, 1)"><i class="fa-regular fa-thumbs-up"></i></button>
                                <button class="icon-button" style="min-height:28px; width:28px; font-size:11px;" onclick="logFeedback({{ $msg->id }}, -1)"><i class="fa-regular fa-thumbs-down"></i></button>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div style="margin:auto; text-align:center; max-width:400px;">
                    <i class="fa-solid fa-robot" style="font-size:48px; color:#0f6fff; margin-bottom:16px;"></i>
                    <h3>Start Clinical Advisory Dialogue</h3>
                    <p style="color:var(--text-muted); font-size:13px;">Ask the clinical helper about diagnosis strategies, dose safety thresholds, or drug contradictions.</p>
                </div>
            @endif
        </div>

        <!-- Role Suggestions -->
        <div style="padding:10px 20px; display:flex; gap:10px; flex-wrap:wrap; background:var(--bg-card); border-top:1px solid var(--glass-border);">
            @if($role === 'doctor')
                <span class="suggestion-chip" onclick="applySuggestion('Review persistent dry cough symptom parameters')">Symptom check: persistent dry cough</span>
                <span class="suggestion-chip" onclick="applySuggestion('Identify interaction risks between Warfarin and Aspirin')">Contraindications: Warfarin + Aspirin</span>
                <span class="suggestion-chip" onclick="applySuggestion('What are common follow-up recommendations for diabetes?')">Diabetes follow-up protocol</span>
            @else
                <span class="suggestion-chip" onclick="applySuggestion('Check general cold symptom guidelines')">Cold symptom guidelines</span>
                <span class="suggestion-chip" onclick="applySuggestion('How can I review my active medicine list?')">Review current medicines</span>
            @endif
        </div>

        <!-- Input Bar -->
        <div style="padding:16px; border-top:1px solid var(--glass-border); display:flex; gap:12px; background:var(--bg-card); align-items:center;">
            <input type="text" id="chat-input" placeholder="Type your clinical query here..." style="flex:1;" onkeypress="if(event.key === 'Enter') sendMessage()">
            <button class="btn btn-primary" onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i> Send</button>
        </div>
    </div>
</div>

<script>
    function applySuggestion(text) {
        document.getElementById('chat-input').value = text;
        sendMessage();
    }

    function sendMessage() {
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;

        input.value = '';

        // Add user message to container locally
        const container = document.getElementById('messages-container');
        const userDiv = document.createElement('div');
        userDiv.className = 'message-bubble user';
        userDiv.innerHTML = `<div style="font-size:11px; margin-bottom:6px; opacity:0.75; font-weight:700;">USER / PRACTITIONER</div><div>${text}</div>`;
        container.appendChild(userDiv);
        container.scrollTop = container.scrollHeight;

        // Post request
        fetch("{{ route('ai.chat.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                message: text,
                conversation_id: "{{ $activeConversation->id ?? '' }}"
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // If it was a new conversation, reload to get active conversation ID
                if (!"{{ $activeConversation->id ?? '' }}") {
                    window.location.href = "{{ route('ai.chat') }}?conversation_id=" + data.conversation_id;
                    return;
                }
                const aiDiv = document.createElement('div');
                aiDiv.className = 'message-bubble ai';
                aiDiv.innerHTML = `<div style="font-size:11px; margin-bottom:6px; opacity:0.75; font-weight:700;">CDSS CO-PILOT ADVISOR</div>
                                   <div>${data.ai_message.message_content.replace(/\n/g, '<br>')}</div>
                                   <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px; border-top:1px solid var(--glass-border); padding-top:6px;">
                                       <button class="icon-button" style="min-height:28px; width:28px; font-size:11px;" onclick="logFeedback(${data.ai_message.id}, 1)"><i class="fa-regular fa-thumbs-up"></i></button>
                                       <button class="icon-button" style="min-height:28px; width:28px; font-size:11px;" onclick="logFeedback(${data.ai_message.id}, -1)"><i class="fa-regular fa-thumbs-down"></i></button>
                                   </div>`;
                container.appendChild(aiDiv);
                container.scrollTop = container.scrollHeight;
            }
        });
    }

    function logFeedback(messageId, rating) {
        fetch(`/ai/chat/${messageId}/feedback`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ rating: rating })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Thank you for rating this CDSS recommendation!');
            }
        });
    }

    function copyConversation() {
        const text = document.getElementById('messages-container').innerText;
        navigator.clipboard.writeText(text);
        alert('Conversation copied to clipboard.');
    }

    function exportChat() {
        alert('Exporting conversation log as CSV...');
    }
</script>
@endsection
