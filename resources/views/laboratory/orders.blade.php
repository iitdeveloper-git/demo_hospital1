@extends('layouts.laboratory', ['title' => 'Lab Orders'])

@section('content')
<div class="orders-wrap">
    <div class="split-layout">
        <!-- Left: Create Lab Order Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Create Lab Order</h2>
            </div>
            
            <form action="{{ route('laboratory.orders.store') }}" method="POST" class="lims-order-form">
                @csrf
                <div class="form-group">
                    <label for="patient_id">Patient</label>
                    <select id="patient_id" name="patient_id" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="doctor_id">Requesting Clinician</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority">Priority Status</label>
                    <select id="priority" name="priority" required>
                        <option value="normal">Normal Outpatient</option>
                        <option value="urgent">Urgent STAT</option>
                        <option value="critical">Critical ICU Priority</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-file-invoice"></i> Book Diagnostics Session</button>
            </form>
        </div>

        <!-- Right: Active Lab Orders Logs -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Diagnostic Lab Orders</h2>
            </div>
            
            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Priority</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $ord)
                            <tr>
                                <td><code>{{ $ord->order_number }}</code></td>
                                <td><strong>{{ $ord->patient->user->name }}</strong></td>
                                <td>{{ $ord->doctor->full_name }}</td>
                                <td><span class="badge" style="background-color:var(--bg-primary); border:1px solid var(--border-color); color:var(--text-muted); font-size:10px; font-weight:700;">{{ strtoupper($ord->priority) }}</span></td>
                                <td><span class="status-pill status-{{ $ord->status }}">{{ ucfirst($ord->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No diagnostic orders issued yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $orders->links() }}
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

    .lims-order-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .lims-order-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .lims-order-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .lims-order-form select {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .lims-order-form select:focus {
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
