@extends('layouts.reception', ['title' => 'Visitor Pass Registry'])

@section('content')
<div class="visitors-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Generate Visitor Pass</h2>
            </div>
            
            <form action="{{ route('reception.visitors.store') }}" method="POST" class="visitor-form">
                @csrf
                <div class="form-group">
                    <label for="name">Visitor Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="patient_name">Patient Name</label>
                    <input type="text" id="patient_name" name="patient_name" required>
                </div>
                <div class="form-group">
                    <label for="relationship">Relationship</label>
                    <input type="text" id="relationship" name="relationship" placeholder="e.g. Spouse" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
                <div class="form-group">
                    <label for="purpose">Purpose of Visit</label>
                    <input type="text" id="purpose" name="purpose" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-id-card"></i> Issue Pass & Check In</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Visitor Logs Today</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Pass ID</th>
                            <th>Visitor</th>
                            <th>Patient Name</th>
                            <th>Relation</th>
                            <th>Check-in Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($visitors as $vis)
                            <tr>
                                <td><code>{{ $vis->pass_number }}</code></td>
                                <td><strong>{{ $vis->name }}</strong></td>
                                <td>{{ $vis->patient_name }}</td>
                                <td>{{ $vis->relationship }}</td>
                                <td>{{ \Carbon\Carbon::parse($vis->entry_time)->format('h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No visitors logged today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $visitors->links() }}
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

    .visitor-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .visitor-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .visitor-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .visitor-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .visitor-form input:focus {
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
