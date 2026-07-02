<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\MedicalReport;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_departments' => Department::count(),
            'today_appointments' => Appointment::whereDate('appointment_at', now()->toDateString())->count(),
            'pending_appointments' => Appointment::where('status', 'scheduled')->count(),
            'completed_appointments' => Appointment::where('status', 'completed')->count(),
            'total_revenue' => Bill::sum('amount'),
            'total_staff' => User::whereIn('role_id', [2, 3, 4])->count(), // doctor, receptionist, lab-technician etc.
        ];

        // Bed occupancy mock data
        $beds = [
            'available' => 120,
            'occupied' => 80,
            'icu' => 15,
            'emergency' => 5,
        ];

        return view('admin.dashboard', compact('metrics', 'beds'));
    }

    public function profile(): View
    {
        return view('admin.profile');
    }

    public function settings(): View
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        ActivityLog::create([
            'user_id' => $request->user()->id,
            'action' => 'update_settings',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'System settings updated successfully!',
        ]);

        return back();
    }

    public function users(Request $request): View
    {
        $query = User::with('role');
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function doctors(Request $request): View
    {
        $query = Doctor::with(['user', 'department']);
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }
        $doctors = $query->paginate(15);
        return view('admin.doctors', compact('doctors'));
    }

    public function patients(Request $request): View
    {
        $query = Patient::with('user');
        if ($request->filled('search')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $patients = $query->paginate(15);
        return view('admin.patients', compact('patients'));
    }

    public function departments(Request $request): View
    {
        $query = Department::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        $departments = $query->paginate(15);
        return view('admin.departments', compact('departments'));
    }

    public function appointments(Request $request): View
    {
        $query = Appointment::with(['patient.user', 'doctor', 'department']);
        if ($request->filled('search')) {
            $query->whereHas('patient.user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $appointments = $query->orderBy('appointment_at', 'desc')->paginate(15);
        return view('admin.appointments', compact('appointments'));
    }

    public function reports(Request $request): View
    {
        $query = MedicalReport::with(['patient.user', 'doctor']);
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        $reports = $query->orderBy('reported_at', 'desc')->paginate(15);
        return view('admin.reports', compact('reports'));
    }

    // Architecture management page endpoints (Pharmacy, Lab, Billing, Inventory, Employees, Insurance, CMS modules)
    public function pharmacy(): View { return view('admin.modules.pharmacy'); }
    public function laboratory(): View { return view('admin.modules.laboratory'); }
    public function billing(): View { return view('admin.modules.billing'); }
    public function inventory(): View { return view('admin.modules.inventory'); }
    public function employees(): View { return view('admin.modules.employees'); }
    public function insurance(): View { return view('admin.modules.insurance'); }
    
    // CMS Pages
    public function blog(): View { return view('admin.cms.blog'); }
    public function gallery(): View { return view('admin.cms.gallery'); }
    public function testimonials(): View { return view('admin.cms.testimonials'); }
    public function faqs(): View { return view('admin.cms.faqs'); }

    public function activityLogs(): View
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(30);
        return view('admin.activity-logs', compact('logs'));
    }

    public function systemHealth(): View
    {
        // Mock hardware stats
        $system = [
            'cpu' => '14%',
            'memory' => '42%',
            'storage' => '28% / 1TB',
            'db_status' => 'Healthy',
            'cache_status' => 'Running (Redis)',
            'version' => 'AarogyaCare Enterprise v1.4.0',
        ];
        return view('admin.system-health', compact('system'));
    }
}
