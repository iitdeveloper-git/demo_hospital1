@extends('layouts.inventory', ['title' => 'Medical Equipment Calibration Directory'])

@section('content')
<div class="equipment-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Register Device Parameters</h2>
            </div>
            
            <form action="{{ url('inventory/equipment') }}" method="POST" class="equip-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Device Name</label>
                    <input type="text" id="name" name="name" placeholder="E.g. Electrocardiogram Monitor" required>
                </div>

                <div class="form-group">
                    <label for="manufacturer">Manufacturer / Brand</label>
                    <input type="text" id="manufacturer" name="manufacturer" placeholder="E.g. GE Healthcare" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-microscope"></i> Log Calibration Parameters</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Medical Devices Calibration Logs</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Device Code</th>
                            <th>Name</th>
                            <th>Manufacturer</th>
                            <th>Last Calibration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipment as $device)
                            <tr>
                                <td><code>{{ $device->equipment_code }}</code></td>
                                <td><strong>{{ $device->name }}</strong></td>
                                <td>{{ $device->manufacturer }}</td>
                                <td>{{ $device->calibration_date ? \Carbon\Carbon::parse($device->calibration_date)->format('M d, Y') : 'N/A' }}</td>
                                <td><span class="status-pill status-{{ $device->status }}">{{ ucfirst($device->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No equipment logs recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $equipment->links() }}
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

    .equip-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .equip-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .equip-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .equip-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .equip-form input:focus {
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
