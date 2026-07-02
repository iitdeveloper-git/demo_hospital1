@extends('layouts.patient', ['title' => 'Medical History Timeline'])

@section('content')
<div class="history-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Clinical Timeline</h2>
        </div>

        <div class="timeline-container">
            @forelse($timeline as $event)
                <div class="timeline-item timeline-{{ $event['color'] }}">
                    <div class="timeline-icon">
                        <i class="fa-solid {{ $event['icon'] }}"></i>
                    </div>
                    <div class="timeline-content">
                        <span class="timeline-date">{{ \Carbon\Carbon::parse($event['date'])->format('F j, Y - h:i A') }}</span>
                        <h3>{{ $event['title'] }}</h3>
                        <h4 class="timeline-subtitle">{{ $event['subtitle'] }}</h4>
                        <p class="timeline-desc">{{ $event['description'] }}</p>
                    </div>
                </div>
            @empty
                <div class="empty-timeline">
                    <i class="fa-solid fa-folder-open"></i>
                    <p>No medical events recorded in your clinical history timeline yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .history-wrap {
        max-width: 900px;
        margin: 0 auto;
    }

    .timeline-container {
        position: relative;
        padding-left: 32px;
        margin-top: 20px;
    }

    .timeline-container::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: var(--border-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 32px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: -32px;
        top: 4px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        border: 4px solid var(--bg-card);
        box-shadow: 0 0 0 1px var(--border-color);
        font-size: 12px;
    }

    .timeline-content {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
    }

    .timeline-date {
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
        margin-bottom: 8px;
    }

    .timeline-content h3 {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
    }

    .timeline-subtitle {
        margin: 0 0 12px;
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
    }

    .timeline-desc {
        margin: 0;
        font-size: 14px;
        color: var(--text-main);
        line-height: 1.5;
    }

    /* Colors */
    .timeline-blue .timeline-icon { background-color: #2563eb; color: #ffffff; }
    .timeline-green .timeline-icon { background-color: #10b981; color: #ffffff; }
    .timeline-purple .timeline-icon { background-color: #8b5cf6; color: #ffffff; }

    .empty-timeline {
        text-align: center;
        padding: 48px 24px;
        color: var(--text-muted);
    }

    .empty-timeline i {
        font-size: 40px;
        margin-bottom: 16px;
    }

    .empty-timeline p {
        font-size: 14px;
        margin: 0;
    }
</style>
@endsection
