@extends('layouts.inventory', ['title' => 'Preventive Calibration Logs'])

@section('content')
<div class="maintenance-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Log Corrective Calibration</h2>
            </div>
            
            <form action="{{ url('inventory/maintenance') }}" method="POST" class="maint-form">
                @csrf
                
                <div class="form-group">
                    <label for="equipment_id">Medical Device Analyzer</label>
                    <select id="equipment_id" name="equipment_id" required>
                        <option value="">Select Equipment</option>
                        @foreach($devices as $dev)
                            <option value="{{ $dev->id }}">{{ $dev->name }} ({{ $dev->equipment_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="cost">Calibration Service Cost ($)</label>
                    <input type="number" id="cost" name="cost" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="description">Calibration/Maintenance Report</label>
                    <textarea id="description" name="description" rows="3" placeholder="Replaced sensor. Ran check cycles..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-wrench"></i> Log Maintenance Action</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Equipment Maintenance Audit Trails</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Device</th>
                            <th>Cost</th>
                            <th>Description</th>
                            <th>Date Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td><strong>{{ $log->equipment->name }}</strong></td>
                                <td><strong>${{ number_format($log->cost, 2) }}</strong></td>
                                <td style="font-size:12px; color:var(--text-muted);">{{ $log->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->maintenance_date)->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No calibration actions logged today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $logs->links() }}
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

    .maint-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .maint-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .maint-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .maint-form select,
    .maint-form input,
    .maint-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .maint-form select:focus,
    .maint-form input:focus,
    .maint-form textarea:focus {
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
