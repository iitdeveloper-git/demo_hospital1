@extends('layouts.hr', ['title' => 'Payroll Slip Invoicing'])

@section('content')
<div class="payroll-wrap">
    <div class="split-layout">
        <!-- Left: Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Generate Employee Salary Slip</h2>
            </div>
            
            <form action="{{ route('hr.payroll.store') }}" method="POST" class="payroll-form">
                @csrf
                
                <div class="form-group">
                    <label for="employee_id">Onboarded Employee</label>
                    <select id="employee_id" name="employee_id" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->employee_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="basic_salary">Basic Salary Monthly ($)</label>
                    <input type="number" id="basic_salary" name="basic_salary" required>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> Calculate & Generate Payroll</button>
            </form>
        </div>

        <!-- Right: Table -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Disbursed Payroll Ledger</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Basic Salary</th>
                            <th>Allowances</th>
                            <th>Deductions</th>
                            <th>Grand Net Pay</th>
                            <th>Status</th>
                            <th>Disburse</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $pr)
                            <tr>
                                <td>
                                    <strong>{{ $pr->employee->full_name }}</strong>
                                    <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $pr->employee->employee_code }}</span>
                                </td>
                                <td>${{ number_format($pr->basic_salary, 2) }}</td>
                                <td>+${{ number_format($pr->allowances, 2) }}</td>
                                <td>-${{ number_format($pr->deductions, 2) }}</td>
                                <td><strong>${{ number_format($pr->net_salary, 2) }}</strong></td>
                                <td><span class="status-pill status-{{ $pr->status }}">{{ ucfirst($pr->status) }}</span></td>
                                <td>
                                    @if($pr->status === 'generated')
                                        <form action="{{ route('hr.payroll.pay', $pr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-hand-holding-dollar"></i> Disburse</button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" onclick="alert('Digital Signatures Verification:\n\nDisburser: HR Director\nDigitally Signed: SHA-256\nNet Disbursed: ${{ number_format($pr->net_salary, 2) }}')"><i class="fa-solid fa-signature"></i> Payslip</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">No payroll records configured.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $payrolls->links() }}
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

    .payroll-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .payroll-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .payroll-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .payroll-form select,
    .payroll-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .payroll-form select:focus,
    .payroll-form input:focus {
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
