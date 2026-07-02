@extends('layouts.laboratory', ['title' => 'Sample Collection & Tracking'])

@section('content')
<div class="samples-wrap">
    <div class="split-layout">
        <!-- Left: Collect Sample Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Collect Specimen Sample</h2>
            </div>
            
            <form action="{{ route('laboratory.samples.store') }}" method="POST" class="sample-collection-form">
                @csrf
                <div class="form-group">
                    <label for="lab_order_id">Pending Lab Order</label>
                    <select id="lab_order_id" name="lab_order_id" required>
                        <option value="">Select Lab Order</option>
                        @foreach($orders as $ord)
                            <option value="{{ $ord->id }}">{{ $ord->order_number }} - {{ $ord->patient->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="sample_type">Specimen Type</label>
                    <select id="sample_type" name="sample_type" required>
                        <option value="Blood">Blood (Purple/Yellow EDTA vial)</option>
                        <option value="Urine">Urine (Sterile container)</option>
                        <option value="Saliva">Saliva (Swab tube)</option>
                        <option value="Stool">Stool (Sterile container)</option>
                        <option value="Tissue">Biopsy Tissue vial</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes">Collection Notes</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Fasting condition verified. Collected from left cubital fossa..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-barcode"></i> Register & Generate Barcode</button>
            </form>
        </div>

        <!-- Right: Specimen Vials Tracking List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Specimen Vials Tracking Logs</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Sample ID</th>
                            <th>Patient</th>
                            <th>Specimen</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($samples as $sample)
                            <tr>
                                <td>
                                    <strong style="color:var(--brand-primary);">{{ $sample->sample_id }}</strong>
                                    <span style="display:block; font-size:10px; color:var(--text-muted);">Collected: {{ \Carbon\Carbon::parse($sample->collection_date)->format('h:i A') }}</span>
                                </td>
                                <td><strong>{{ $sample->labOrder->patient->user->name }}</strong></td>
                                <td><span class="type-badge">{{ $sample->sample_type }}</span></td>
                                <td><span class="status-pill status-{{ $sample->status }}">{{ ucfirst($sample->status) }}</span></td>
                                <td>
                                    @if($sample->status !== 'completed' && $sample->status !== 'rejected')
                                        <form action="{{ route('laboratory.samples.status', $sample->id) }}" method="POST" style="display:flex; gap:8px;">
                                            @csrf
                                            <select name="status" style="padding: 4px 8px; border-radius:4px; border:1px solid var(--border-color); font-size:11px;" onchange="this.form.submit()">
                                                <option value="">Update Status</option>
                                                <option value="received">Mark Received</option>
                                                <option value="processing">Start Processing</option>
                                                <option value="completed">Complete/Verify</option>
                                                <option value="rejected">Reject Sample</option>
                                            </select>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No specimens collected today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $samples->links() }}
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

    .sample-collection-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .sample-collection-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .sample-collection-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .sample-collection-form select,
    .sample-collection-form textarea {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .sample-collection-form select:focus,
    .sample-collection-form textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }

    .type-badge {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
    }

    @media (max-width: 992px) {
        .split-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
