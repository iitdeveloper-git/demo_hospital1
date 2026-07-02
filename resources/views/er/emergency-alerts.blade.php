@extends('layouts.er', ['title' => 'Critical Care Sirens'])

@section('content')
<div class="alerts-wrap">
    <div class="split-layout">
        <!-- Left: Sirens trigger buttons -->
        <div class="panel form-panel" style="border-left: 4px solid #ef4444;">
            <div class="panel-header">
                <h2>Trigger Emergency Sirens</h2>
            </div>
            
            <div style="display:flex; flex-direction:column; gap:16px;">
                <form action="{{ route('er.emergency-alerts.code-blue') }}" method="POST">
                    @csrf
                    <div class="form-group" style="display:flex; flex-direction:column; gap:6px; margin-bottom:12px;">
                        <label for="room" style="font-size:13px; font-weight:600; color:var(--text-muted);">Trauma Room Location</label>
                        <input type="text" id="room" name="room" placeholder="E.g. Room 102" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px; width:100%; box-sizing:border-box;">
                    </div>
                    <button type="submit" class="btn btn-danger" style="width:100%; background-color:#ef4444; justify-content:center;"><i class="fa-solid fa-bell"></i> Broadcast Code Blue</button>
                </form>

                <div style="border-top:1px solid var(--border-color); padding-top:16px;"></div>

                <form action="{{ route('er.emergency-alerts.disaster') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width:100%; background-color:#b91c1c; justify-content:center;"><i class="fa-solid fa-triangle-exclamation"></i> Activate Disaster Mode</button>
                </form>
            </div>
        </div>

        <!-- Right: Log list -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Sirens & Disaster Mode Activity Log</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Alert description</th>
                            <th>Alert Category</th>
                            <th>Status</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alerts as $alert)
                            <tr>
                                <td><strong>{{ $alert->title }}</strong></td>
                                <td><span class="status-pill status-scheduled">{{ $alert->type }}</span></td>
                                <td><span class="status-pill status-{{ $alert->status }}">{{ ucfirst($alert->status) }}</span></td>
                                <td>{{ $alert->created_at->format('M d, Y - H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No emergency sirens triggered today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $alerts->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    .split-layout {
        display: grid;
        grid-template-columns: 0.9fr 1.1fr;
        gap: 32px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
