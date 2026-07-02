@extends('layouts.billing', ['title' => 'Insurance Claims'])

@section('content')
<div class="insurance-wrap">
    <div class="split-layout">
        <!-- Left Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Dispatch Insurance Claim</h2>
            </div>
            
            <form action="{{ route('billing.insurance.store') }}" method="POST" class="claim-form">
                @csrf
                
                <div class="form-group">
                    <label for="invoice_header_id">Patient Invoice</label>
                    <select id="invoice_header_id" name="invoice_header_id" required>
                        <option value="">Select Invoice</option>
                        @foreach($invoices as $inv)
                            <option value="{{ $inv->id }}">{{ $inv->invoice_number }} - {{ $inv->patient->user->name }} (${{ number_format($inv->grand_total, 2) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="company_id">Insurance Company</label>
                    <select id="company_id" name="company_id" required>
                        <option value="">Select Insurance Provider</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="policy_number">Carrier Policy Number</label>
                    <input type="text" id="policy_number" name="policy_number" required>
                </div>

                <div class="form-group">
                    <label for="claim_amount">Claim Value ($)</label>
                    <input type="number" id="claim_amount" name="claim_amount" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-shield-halved"></i> Dispatch Claim</button>
            </form>
        </div>

        <!-- Right List -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Dispatched Carrier Claims Registry</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Carrier</th>
                            <th>Policy Number</th>
                            <th>Claim Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($claims as $claim)
                            <tr>
                                <td><code>{{ $claim->invoiceHeader->invoice_number }}</code></td>
                                <td><strong>{{ $claim->company->name }}</strong></td>
                                <td><code>{{ $claim->policy_number }}</code></td>
                                <td><strong>${{ number_format($claim->claim_amount, 2) }}</strong></td>
                                <td><span class="status-pill status-{{ $claim->status }}">{{ ucfirst($claim->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-state">No insurance claims dispatched today.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $claims->links() }}
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

    .claim-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .claim-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .claim-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .claim-form select,
    .claim-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .claim-form select:focus,
    .claim-form input:focus {
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
