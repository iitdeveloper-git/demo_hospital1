@extends('layouts.er', ['title' => 'Operation Theatre Scheduler'])

@section('content')
<div class="ot-wrap">
    <div class="split-layout">
        <!-- Left: Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Book Emergency Surgery</h2>
            </div>
            
            <form action="{{ url('er/operation-theatre') }}" method="POST" class="ot-form">
                @csrf
                
                <div class="form-group">
                    <label for="emergency_case_id">Trauma Case Ref</label>
                    <select id="emergency_case_id" name="emergency_case_id" required>
                        <option value="">Select Case</option>
                        @foreach($cases as $case)
                            <option value="{{ $case->id }}">{{ $case->case_number }} - {{ $case->patient ? $case->patient->user->name : 'Unknown' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="surgeon_id">Lead Surgeon</label>
                    <select id="surgeon_id" name="surgeon_id" required>
                        <option value="">Select Surgeon</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="ot_number">Operation Theatre Number</label>
                    <input type="text" id="ot_number" name="ot_number" placeholder="E.g. OT-1" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-hospital"></i> Schedule Emergency OT</button>
            </form>
        </div>

        <!-- Right: Table -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Active Surgery Schedule</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Case Ref</th>
                            <th>Surgeon</th>
                            <th>OT Number</th>
                            <th>Estimated Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td><code>{{ $booking->emergencyCase->case_number }}</code></td>
                                <td><strong>{{ $booking->surgeon->full_name }}</strong></td>
                                <td><strong>{{ $booking->ot_number }}</strong></td>
                                <td>{{ $booking->estimated_duration }} Min</td>
                                <td><span class="status-pill status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No active surgeries scheduled.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $bookings->links() }}
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

    .ot-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .ot-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .ot-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .ot-form select,
    .ot-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .ot-form select:focus,
    .ot-form input:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
