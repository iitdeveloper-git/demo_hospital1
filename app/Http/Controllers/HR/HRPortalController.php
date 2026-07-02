<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\ShiftSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HRPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'doctors' => Employee::whereHas('designation', fn($q) => $q->where('name', 'like', '%Doctor%'))->count(),
            'nurses' => Employee::whereHas('designation', fn($q) => $q->where('name', 'like', '%Nurse%'))->count(),
            'attendance_today' => AttendanceLog::whereDate('check_in', now()->toDateString())->count(),
            'leave_today' => LeaveRequest::where('status', 'approved')->count(),
            'monthly_payroll' => Payroll::where('status', 'paid')->sum('net_salary'),
        ];

        return view('hr.dashboard', compact('metrics'));
    }

    public function employees(Request $request): View
    {
        $departments = Department::all();
        $designations = Designation::all();
        
        $query = Employee::with(['department', 'designation']);
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_code', 'like', '%' . $request->search . '%');
        }
        $employees = $query->paginate(15);
        return view('hr.employees', compact('departments', 'designations', 'employees'));
    }

    public function storeEmployee(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'department_id' => ['required', 'exists:departments,id'],
            'designation_id' => ['required', 'exists:designations,id'],
        ]);

        Employee::create([
            'employee_code' => 'EMP-' . strtoupper(Str::random(6)),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'status' => 'active',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Employee registered successfully!',
        ]);

        return back();
    }

    public function departments(): View
    {
        $departments = Department::withCount('doctors')->paginate(15);
        return view('hr.departments', compact('departments'));
    }

    public function designations(): View
    {
        $designations = Designation::paginate(15);
        return view('hr.designations', compact('designations'));
    }

    public function attendance(): View
    {
        $attendance = AttendanceLog::with('employee')->orderBy('check_in', 'desc')->paginate(15);
        return view('hr.attendance', compact('attendance'));
    }

    public function shifts(): View
    {
        $shifts = ShiftSchedule::with('employee')->paginate(15);
        return view('hr.shifts', compact('shifts'));
    }

    public function leave(): View
    {
        $requests = LeaveRequest::with('employee')->orderBy('id', 'desc')->paginate(15);
        return view('hr.leave', compact('requests'));
    }

    public function approveLeave($id): RedirectResponse
    {
        $lr = LeaveRequest::findOrFail($id);
        $lr->update(['status' => 'approved']);

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Leave Request approved.',
        ]);
    }

    public function rejectLeave($id): RedirectResponse
    {
        $lr = LeaveRequest::findOrFail($id);
        $lr->update(['status' => 'rejected']);

        return back()->with('toast', [
            'type' => 'danger',
            'message' => 'Leave Request rejected.',
        ]);
    }

    public function payroll(): View
    {
        $employees = Employee::all();
        $payrolls = Payroll::with('employee')->orderBy('id', 'desc')->paginate(15);
        return view('hr.payroll', compact('employees', 'payrolls'));
    }

    public function storePayroll(Request $request): RedirectResponse
    {
        $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'basic_salary' => ['required', 'numeric', 'min:0'],
        ]);

        $allowances = $request->basic_salary * 0.10; // 10% mock allowances
        $deductions = $request->basic_salary * 0.05; // 5% mock deductions
        $tax = $request->basic_salary * 0.12; // 12% mock tax
        $net = $request->basic_salary + $allowances - $deductions - $tax;

        Payroll::create([
            'employee_id' => $request->employee_id,
            'basic_salary' => $request->basic_salary,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'tax' => $tax,
            'net_salary' => $net,
            'status' => 'generated',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Salary slip payroll generated.',
        ]);

        return back();
    }

    public function payPayroll($id): RedirectResponse
    {
        $pr = Payroll::findOrFail($id);
        $pr->update(['status' => 'paid']);

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Salary disbursed successfully.',
        ]);
    }

    public function reports(): View
    {
        return view('hr.reports');
    }

    public function settings(): View
    {
        return view('hr.settings');
    }
}
