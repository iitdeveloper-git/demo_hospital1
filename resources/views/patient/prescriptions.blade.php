@extends('layouts.patient', ['title' => 'My Prescriptions'])

@section('content')
<div class="prescriptions-wrap">
    <div class="panel">
        <div class="panel-header">
            <h2>Active Medications</h2>
        </div>

        <div class="table-wrap">
            <table class="portal-table">
                <thead>
                    <tr>
                        <th>Medication</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                        <th>Prescribed By</th>
                        <th>Date Issued</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $rx)
                        <tr>
                            <td>
                                <div class="med-name-wrap">
                                    <span class="pill-icon"><i class="fa-solid fa-pills"></i></span>
                                    <strong>{{ $rx->medication_name }}</strong>
                                </div>
                            </td>
                            <td>{{ $rx->dosage }}</td>
                            <td><span class="freq-tag">{{ $rx->frequency }}</span></td>
                            <td>{{ $rx->duration }}</td>
                            <td>{{ $rx->doctor->full_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($rx->issued_at)->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm" onclick="alert('Medication Directions:\n\nInstructions: {{ addslashes($rx->instructions ?? 'No specific instructions provided.') }}')">
                                    <i class="fa-solid fa-info-circle"></i> Instructions
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">No prescription records found on your profile.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-container">
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>

<style>
    .med-name-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .pill-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background-color: rgba(139, 92, 246, 0.08);
        color: #8b5cf6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }

    .freq-tag {
        background-color: var(--brand-soft);
        color: var(--brand-primary);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .pagination-container {
        margin-top: 24px;
        display: flex;
        justify-content: flex-end;
    }
</style>
@endsection
