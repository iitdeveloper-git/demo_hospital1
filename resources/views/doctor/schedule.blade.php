@extends('layouts.doctor', ['title' => 'My Schedule & Calendar'])

@section('content')
<div class="schedule-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Clinical Calendar Summary</h2>
        </div>
        <div class="schedule-grid">
            <div class="days-list">
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <div class="day-card {{ in_array(substr($day, 0, 3), $doctor->working_days ?? []) ? 'working' : 'non-working' }}">
                        <strong>{{ $day }}</strong>
                        <span>{{ in_array(substr($day, 0, 3), $doctor->working_days ?? []) ? $doctor->working_hours : 'Off Duty' }}</span>
                    </div>
                @endforeach
            </div>

            <div class="appointments-list-panel">
                <h3>Today's Consultation Slots</h3>
                <div class="timeline-slots">
                    @forelse($appointments->filter(fn($a) => \Carbon\Carbon::parse($a->appointment_at)->isToday()) as $slot)
                        <div class="slot-row">
                            <span class="slot-time">{{ \Carbon\Carbon::parse($slot->appointment_at)->format('h:i A') }}</span>
                            <div class="slot-card">
                                <strong>{{ $slot->patient->user->name }}</strong>
                                <span>{{ $slot->department->name }} | {{ ucfirst($slot->type) }}</span>
                                <span class="status-pill status-{{ $slot->status }}">{{ ucfirst($slot->status) }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="empty-state">No consultation sessions booked for today.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .schedule-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .days-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .day-card {
        padding: 16px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: var(--bg-primary);
    }

    .day-card.working {
        border-left: 4px solid var(--brand-primary);
    }

    .day-card.non-working {
        opacity: 0.5;
    }

    .day-card strong {
        font-size: 14px;
    }

    .day-card span {
        font-size: 12px;
        color: var(--text-muted);
    }

    .timeline-slots {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 16px;
    }

    .slot-row {
        display: grid;
        grid-template-columns: 80px 1fr;
        align-items: center;
        gap: 16px;
    }

    .slot-time {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .slot-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13.5px;
    }

    .slot-card strong {
        font-weight: 600;
    }

    .slot-card span {
        color: var(--text-muted);
    }

    @media (max-width: 768px) {
        .schedule-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
