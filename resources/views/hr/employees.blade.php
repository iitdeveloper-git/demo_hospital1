@extends('layouts.hr', ['title' => 'Employee Directory'])

@section('content')
<div class="employees-wrap">
    <div class="split-layout">
        <!-- Left: Onboard Form -->
        <div class="panel form-panel">
            <div class="panel-header">
                <h2>Onboard New Employee</h2>
            </div>
            
            <form action="{{ url('hr/employees') }}" method="POST" class="employee-form">
                @csrf
                
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone">
                </div>

                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select id="department_id" name="department_id" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="designation_id">Designation Role</label>
                    <select id="designation_id" name="designation_id" required>
                        <option value="">Select Designation</option>
                        @foreach($designations as $desg)
                            <option value="{{ $desg->id }}">{{ $desg->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-user-plus"></i> Onboard Profile</button>
            </form>
        </div>

        <!-- Right: Employee Directory Table -->
        <div class="panel list-panel">
            <div class="panel-header">
                <h2>Employee Directory</h2>
            </div>

            <div class="table-wrap">
                <table class="portal-table">
                    <thead>
                        <tr>
                            <th>Emp ID</th>
                            <th>Full Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $emp)
                            <tr>
                                <td><code>{{ $emp->employee_code }}</code></td>
                                <td><strong>{{ $emp->full_name }}</strong></td>
                                <td>{{ $emp->department->name }}</td>
                                <td>{{ $emp->designation->name }}</td>
                                <td>{{ $emp->email }}</td>
                                <td><span class="status-pill status-{{ $emp->status }}">{{ ucfirst($emp->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No employees onboarded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrap" style="margin-top:20px;">
                {{ $employees->links() }}
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

    .employee-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .employee-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .employee-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .employee-form select,
    .employee-form input {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .employee-form select:focus,
    .employee-form input:focus {
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
