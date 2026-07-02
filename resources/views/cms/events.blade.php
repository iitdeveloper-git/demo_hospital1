@extends('layouts.cms', ['title' => 'Events & Health Camps'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Events, Camps & Seminars</h2>
        <button class="btn btn-primary" onclick="alert('Opening event schedule form...')"><i class="fa-solid fa-plus"></i> Schedule Event</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Event Title</th>
                    <th>Location</th>
                    <th>Start Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $e)
                    <tr>
                        <td>
                            <strong>{{ $e->title }}</strong>
                            <small style="display:block; color:var(--text-muted); font-size:11px; max-width:400px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $e->description }}</small>
                        </td>
                        <td>{{ $e->location }}</td>
                        <td>{{ $e->start_at }}</td>
                        <td>
                            <span class="status-pill status-{{ $e->status === 'upcoming' ? 'pending' : 'paid' }}">
                                {{ strtoupper($e->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No events scheduled.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $events->links() }}
    </div>
</div>
@endsection
