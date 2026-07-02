<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\QueueToken;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReceptionPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'walk_ins' => Appointment::where('type', 'walk-in')->whereDate('appointment_at', now()->toDateString())->count(),
            'appointments' => Appointment::whereDate('appointment_at', now()->toDateString())->count(),
            'waiting' => QueueToken::where('status', 'waiting')->count(),
            'checked_in' => Appointment::where('status', 'checked-in')->count(),
            'checked_out' => Appointment::where('status', 'completed')->count(),
            'admissions' => Admission::where('status', 'admitted')->count(),
            'visitors' => Visitor::whereDate('entry_time', now()->toDateString())->count(),
        ];

        // Bed occupancy status
        $beds = [
            'general' => 60,
            'private' => 15,
            'semi_private' => 30,
            'icu' => 10,
        ];

        return view('reception.dashboard', compact('metrics', 'beds'));
    }

    public function patients(Request $request): View
    {
        $query = Patient::with('user');
        if ($request->filled('search')) {
            $query->where('patient_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $patients = $query->paginate(15);
        return view('reception.patients', compact('patients'));
    }

    public function newPatient(): View
    {
        return view('reception.new-patient');
    }

    public function storePatient(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'gender' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'email' => ['required', 'email', 'unique:users,email'],
            'mobile' => ['required', 'string'],
            'emergency_contact' => ['required', 'string'],
        ]);

        // Create User
        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role_id' => 3, // patient role ID
            'status' => 'active',
        ]);

        // Create Patient
        Patient::create([
            'user_id' => $user->id,
            'patient_code' => 'PAT-' . strtoupper(Str::random(5)),
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'emergency_contact' => $request->emergency_contact,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'New Patient registered successfully!',
        ]);

        return redirect()->route('reception.patients');
    }

    public function walkIn(): View
    {
        $patients = Patient::with('user')->get();
        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::where('status', 'active')->get();
        return view('reception.walk-in', compact('patients', 'departments', 'doctors'));
    }

    public function storeWalkIn(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'time_slot' => ['required', 'string'],
        ]);

        // Create Appointment
        $appt = Appointment::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'appointment_at' => now()->toDateString() . ' ' . $request->time_slot,
            'type' => 'walk-in',
            'status' => 'checked-in',
        ]);

        // Generate Token
        $prefix = chr(64 + $request->department_id); // A, B, C based on dept ID
        $count = QueueToken::where('department_id', $request->department_id)->count() + 1;
        $tokenNum = $prefix . str_pad((string)$count, 3, '0', STR_PAD_LEFT);

        QueueToken::create([
            'appointment_id' => $appt->id,
            'patient_id' => $request->patient_id,
            'department_id' => $request->department_id,
            'doctor_id' => $request->doctor_id,
            'token_number' => $tokenNum,
            'status' => 'waiting',
            'priority' => 'normal',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Walk-in session booked. Token generated: ' . $tokenNum,
        ]);

        return redirect()->route('reception.queue');
    }

    public function appointments(Request $request): View
    {
        $query = Appointment::with(['patient.user', 'doctor', 'department']);
        if ($request->filled('search')) {
            $query->whereHas('patient.user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $appointments = $query->orderBy('appointment_at', 'desc')->paginate(15);
        return view('reception.appointments', compact('appointments'));
    }

    public function checkIn($id): RedirectResponse
    {
        $appt = Appointment::findOrFail($id);
        $appt->update(['status' => 'checked-in']);

        // Generate Queue Token if it doesn't exist
        $exists = QueueToken::where('appointment_id', $appt->id)->exists();
        if (!$exists) {
            $prefix = chr(64 + $appt->department_id);
            $count = QueueToken::where('department_id', $appt->department_id)->count() + 1;
            $tokenNum = $prefix . str_pad((string)$count, 3, '0', STR_PAD_LEFT);

            QueueToken::create([
                'appointment_id' => $appt->id,
                'patient_id' => $appt->patient_id,
                'department_id' => $appt->department_id,
                'doctor_id' => $appt->doctor_id,
                'token_number' => $tokenNum,
                'status' => 'waiting',
                'priority' => 'normal',
            ]);
        }

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Patient checked-in and queue token allocated!',
        ]);
    }

    public function checkOut($id): RedirectResponse
    {
        $appt = Appointment::findOrFail($id);
        $appt->update(['status' => 'completed']);

        // Complete queue token
        QueueToken::where('appointment_id', $appt->id)->update(['status' => 'completed']);

        // Generate Bill invoice
        Bill::create([
            'patient_id' => $appt->patient_id,
            'appointment_id' => $appt->id,
            'amount' => $appt->doctor->consultation_fee,
            'tax' => $appt->doctor->consultation_fee * 0.18, // 18% GST mock
            'discount' => 0.00,
            'total' => $appt->doctor->consultation_fee * 1.18,
            'status' => 'paid',
            'payment_method' => 'cash',
        ]);

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Consultation completed and checkout invoice finalized.',
        ]);
    }

    public function queue(): View
    {
        $tokens = QueueToken::with(['patient.user', 'department', 'doctor'])->orderBy('id', 'desc')->paginate(15);
        return view('reception.queue', compact('tokens'));
    }

    public function visitors(): View
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->paginate(15);
        return view('reception.visitors', compact('visitors'));
    }

    public function storeVisitor(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'patient_name' => ['required', 'string', 'max:100'],
            'relationship' => ['required', 'string'],
            'mobile' => ['required', 'string'],
            'purpose' => ['required', 'string'],
        ]);

        Visitor::create([
            'name' => $request->name,
            'patient_name' => $request->patient_name,
            'relationship' => $request->relationship,
            'mobile' => $request->mobile,
            'purpose' => $request->purpose,
            'pass_number' => 'PASS-' . strtoupper(Str::random(6)),
            'entry_time' => now(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Visitor pass generated successfully!',
        ]);

        return back();
    }

    public function admissions(): View
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::where('status', 'active')->get();
        $admissions = Admission::with(['patient.user', 'doctor'])->orderBy('created_at', 'desc')->paginate(15);
        return view('reception.admissions', compact('patients', 'doctors', 'admissions'));
    }

    public function storeAdmission(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'ward_type' => ['required', 'string'],
            'bed_number' => ['required', 'string'],
        ]);

        Admission::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'ward_type' => $request->ward_type,
            'bed_number' => $request->bed_number,
            'notes' => $request->notes,
            'status' => 'admitted',
            'admission_date' => now(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Patient admitted and bed allocated!',
        ]);

        return back();
    }

    public function payments(): View
    {
        $bills = Bill::with(['patient.user', 'appointment'])->orderBy('created_at', 'desc')->paginate(15);
        return view('reception.payments', compact('bills'));
    }

    public function profile(): View
    {
        return view('reception.profile');
    }
}
