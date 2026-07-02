@extends('layouts.ai', ['title' => 'AI Clinical Alerts Desk'])

@section('content')
<div class="glass-panel">
    <h2>Clinical Alerts Dispatch</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Real-time high-risk vitals, contraindications, and critical abnormalities requiring medical acknowledgment.</p>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Alert Type</th>
                    <th>Patient Code</th>
                    <th>Severity</th>
                    <th>Message Warning</th>
                    <th>Status / Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alerts as $alert)
                    <tr style="background: {{ $alert->severity === 'critical' && !$alert->is_resolved ? 'rgba(239,68,68,0.02)' : 'transparent' }};">
                        <td>
                            <strong style="text-transform:uppercase; font-size:12px; color:#0f6fff;">
                                {{ str_replace('_', ' ', $alert->alert_type) }}
                            </strong>
                        </td>
                        <td>
                            <strong>{{ $alert->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $alert->patient->patient_code }}</span>
                        </td>
                        <td>
                            <span class="status-pill status-{{ $alert->severity === 'critical' ? 'cancelled' : 'pending' }}" style="font-weight:700;">
                                {{ strtoupper($alert->severity) }}
                            </span>
                        </td>
                        <td>
                            <p style="margin:0; font-size:13.5px; max-width:420px;">{{ $alert->message }}</p>
                        </td>
                        <td>
                            @if($alert->is_resolved)
                                <span class="status-pill status-paid" style="font-weight:700;"><i class="fa-solid fa-circle-check"></i> RESOLVED</span>
                                <small style="display:block; font-size:10px; color:var(--text-muted); margin-top:4px;">By: {{ $alert->resolvedByUser->name ?? 'System' }}</small>
                            @else
                                <form action="{{ route('ai.alerts.resolve', ['id' => $alert->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="min-height:32px; font-size:12px; padding:0 12px;">Acknowledge & Resolve</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No clinical alerts logged.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $alerts->links() }}
    </div>
</div>
@endsection
