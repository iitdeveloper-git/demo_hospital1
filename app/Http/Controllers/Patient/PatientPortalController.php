<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\MedicalReport;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PatientPortalController extends Controller
{
    private function getPatient(Request $request)
    {
        $patient = $request->user()->patient;
        if (!$patient) {
            abort(404, 'Patient profile not found.');
        }
        return $patient;
    }

    public function dashboard(Request $request): View
    {
        $patient = $this->getPatient($request);

        $appointments = $patient->appointments()->with(['doctor', 'department'])->orderBy('appointment_at', 'desc')->get();
        $nextAppointment = $appointments->where('appointment_at', '>', now())->first();
        
        $prescriptions = $patient->prescriptions()->with('doctor')->orderBy('issued_at', 'desc')->limit(5)->get();
        $reports = $patient->medicalReports()->with('doctor')->orderBy('reported_at', 'desc')->limit(5)->get();
        $bills = $patient->bills()->orderBy('due_at', 'desc')->limit(5)->get();

        // Calculate metrics
        $metrics = [
            'total_appointments' => $appointments->count(),
            'upcoming_appointments' => $appointments->where('appointment_at', '>', now())->count(),
            'active_prescriptions' => $prescriptions->count(),
            'pending_bills' => $patient->bills()->where('status', 'pending')->sum('amount'),
        ];

        return view('patient.dashboard', compact('patient', 'metrics', 'nextAppointment', 'prescriptions', 'reports', 'bills'));
    }

    public function profile(Request $request): View
    {
        $patient = $this->getPatient($request);
        return view('patient.profile', compact('patient'));
    }

    public function appointments(Request $request): View
    {
        $patient = $this->getPatient($request);
        $appointments = $patient->appointments()->with(['doctor', 'department'])->orderBy('appointment_at', 'desc')->paginate(10);
        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::with('user')->get();
        
        return view('patient.appointments', compact('patient', 'appointments', 'departments', 'doctors'));
    }

    public function medicalHistory(Request $request): View
    {
        $patient = $this->getPatient($request);
        $appointments = $patient->appointments()->with(['doctor', 'department'])->get();
        $reports = $patient->medicalReports()->with('doctor')->get();
        $prescriptions = $patient->prescriptions()->with('doctor')->get();

        // Merge into a timeline
        $timeline = collect();

        foreach ($appointments as $appt) {
            $timeline->push([
                'type' => 'appointment',
                'date' => $appt->appointment_at,
                'title' => 'Consultation with ' . $appt->doctor->full_name,
                'subtitle' => $appt->department->name . ' - Status: ' . ucfirst($appt->status),
                'description' => 'Reason: ' . $appt->reason,
                'icon' => 'fa-calendar-check',
                'color' => 'blue',
            ]);
        }

        foreach ($reports as $report) {
            $timeline->push([
                'type' => 'report',
                'date' => $report->reported_at,
                'title' => 'Report Uploaded: ' . $report->title,
                'subtitle' => 'Type: ' . strtoupper($report->report_type) . ' - Status: ' . ucfirst($report->status),
                'description' => $report->summary,
                'icon' => 'fa-file-medical',
                'color' => 'green',
            ]);
        }

        foreach ($prescriptions as $rx) {
            $timeline->push([
                'type' => 'prescription',
                'date' => $rx->issued_at,
                'title' => 'Prescription Issued: ' . $rx->medication_name,
                'subtitle' => 'Dosage: ' . $rx->dosage . ' | ' . $rx->frequency,
                'description' => 'Duration: ' . $rx->duration . ' | Instructions: ' . $rx->instructions,
                'icon' => 'fa-prescription-bottle-medical',
                'color' => 'purple',
            ]);
        }

        $timeline = $timeline->sortByDesc('date')->values();

        return view('patient.medical-history', compact('patient', 'timeline'));
    }

    public function reports(Request $request): View
    {
        $patient = $this->getPatient($request);
        $reports = $patient->medicalReports()->with('doctor')->orderBy('reported_at', 'desc')->paginate(10);
        return view('patient.reports', compact('patient', 'reports'));
    }

    public function prescriptions(Request $request): View
    {
        $patient = $this->getPatient($request);
        $prescriptions = $patient->prescriptions()->with('doctor')->orderBy('issued_at', 'desc')->paginate(10);
        return view('patient.prescriptions', compact('patient', 'prescriptions'));
    }

    public function payments(Request $request): View
    {
        $patient = $this->getPatient($request);
        $bills = $patient->bills()->orderBy('due_at', 'desc')->paginate(10);
        return view('patient.payments', compact('patient', 'bills'));
    }

    public function insurance(Request $request): View
    {
        $patient = $this->getPatient($request);
        return view('patient.insurance', compact('patient'));
    }

    public function settings(Request $request): View
    {
        $patient = $this->getPatient($request);
        return view('patient.settings', compact('patient'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $patient = $this->getPatient($request);
        $user = $request->user();

        if ($request->has('profile_update')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'emergency_contact' => ['required', 'string', 'max:20'],
                'insurance_provider' => ['nullable', 'string', 'max:100'],
            ]);

            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            $patient->update([
                'emergency_contact' => $request->emergency_contact,
                'insurance_provider' => $request->insurance_provider,
            ]);

            $request->session()->flash('toast', [
                'type' => 'success',
                'message' => 'Profile updated successfully!',
            ]);
        }

        if ($request->has('password_update')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            $request->session()->flash('toast', [
                'type' => 'success',
                'message' => 'Password updated successfully!',
            ]);
        }

        if ($request->has('tfa_update')) {
            $request->session()->flash('toast', [
                'type' => 'success',
                'message' => 'Two-Factor Authentication settings updated!',
            ]);
        }

        return back();
    }
}
