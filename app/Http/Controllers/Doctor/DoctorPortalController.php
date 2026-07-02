<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\MedicalReport;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DoctorPortalController extends Controller
{
    private function getDoctor(Request $request): Doctor
    {
        $doctor = $request->user()->doctor;
        if (!$doctor) {
            abort(404, 'Doctor profile not found.');
        }
        return $doctor;
    }

    public function dashboard(Request $request): View
    {
        $doctor = $this->getDoctor($request);

        $appointments = $doctor->appointments()->with(['patient.user', 'department'])->orderBy('appointment_at')->get();
        $todayAppointments = $appointments->filter(fn($a) => \Carbon\Carbon::parse($a->appointment_at)->isToday());
        
        $metrics = [
            'today_count' => $todayAppointments->count(),
            'upcoming_count' => $appointments->where('appointment_at', '>', now())->count(),
            'completed_count' => $appointments->where('status', 'completed')->count(),
            'total_patients' => Patient::whereHas('appointments', fn($q) => $q->where('doctor_id', $doctor->id))->count(),
            'pending_reports' => MedicalReport::where('doctor_id', $doctor->id)->where('status', 'review')->count(),
            'avg_rating' => $doctor->rating,
        ];

        return view('doctor.dashboard', compact('doctor', 'metrics', 'todayAppointments'));
    }

    public function profile(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        return view('doctor.profile', compact('doctor'));
    }

    public function schedule(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        $appointments = $doctor->appointments()->with(['patient.user', 'department'])->orderBy('appointment_at')->get();
        return view('doctor.schedule', compact('doctor', 'appointments'));
    }

    public function appointments(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        $appointments = $doctor->appointments()->with(['patient.user', 'department'])->orderBy('appointment_at', 'desc')->paginate(15);
        return view('doctor.appointments', compact('doctor', 'appointments'));
    }

    public function updateAppointment(Request $request, int $id): RedirectResponse
    {
        $doctor = $this->getDoctor($request);
        $appointment = $doctor->appointments()->findOrFail($id);

        $request->validate([
            'status' => ['required', 'string', 'in:scheduled,checked-in,completed,cancelled'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->update([
            'status' => $request->status,
            'reason' => $request->notes ?? $appointment->reason,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Appointment status updated successfully!',
        ]);

        return back();
    }

    public function patients(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        $query = Patient::whereHas('appointments', fn($q) => $q->where('doctor_id', $doctor->id))->with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', fn($q) => $q->where('name', 'like', "%{$search}%"));
        }

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        if ($request->filled('blood_group')) {
            $query->where('blood_group', $request->blood_group);
        }

        $patients = $query->paginate(15);
        return view('doctor.patients', compact('doctor', 'patients'));
    }

    public function patientShow(Request $request, int $id): View
    {
        $doctor = $this->getDoctor($request);
        $patient = Patient::with(['user', 'appointments' => fn($q) => $q->where('doctor_id', $doctor->id)])->findOrFail($id);
        
        $vitals = MedicalRecord::where('patient_id', $patient->id)->orderBy('recorded_at', 'desc')->get();
        $prescriptions = Prescription::where('patient_id', $patient->id)->where('doctor_id', $doctor->id)->orderBy('issued_at', 'desc')->get();
        $reports = MedicalReport::where('patient_id', $patient->id)->where('doctor_id', $doctor->id)->orderBy('reported_at', 'desc')->get();

        return view('doctor.patient-profile', compact('doctor', 'patient', 'vitals', 'prescriptions', 'reports'));
    }

    public function addVitals(Request $request, int $id): RedirectResponse
    {
        $doctor = $this->getDoctor($request);
        $patient = Patient::findOrFail($id);

        $request->validate([
            'blood_pressure' => ['nullable', 'string', 'max:20'],
            'heart_rate' => ['nullable', 'integer', 'min:30', 'max:220'],
            'temperature' => ['nullable', 'numeric', 'min:90', 'max:110'],
            'oxygen_level' => ['nullable', 'integer', 'min:50', 'max:100'],
            'blood_sugar' => ['nullable', 'integer', 'min:30', 'max:600'],
            'weight' => ['nullable', 'numeric', 'min:1', 'max:500'],
            'height' => ['nullable', 'numeric', 'min:10', 'max:300'],
            'medical_notes' => ['nullable', 'string'],
        ]);

        // Calculate BMI
        $bmi = null;
        if ($request->weight && $request->height) {
            $heightInMeters = $request->height / 100;
            $bmi = $request->weight / ($heightInMeters * $heightInMeters);
        }

        MedicalRecord::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'blood_pressure' => $request->blood_pressure,
            'heart_rate' => $request->heart_rate,
            'temperature' => $request->temperature,
            'oxygen_level' => $request->oxygen_level,
            'blood_sugar' => $request->blood_sugar,
            'weight' => $request->weight,
            'height' => $request->height,
            'bmi' => $bmi,
            'medical_notes' => $request->medical_notes,
            'recorded_at' => now(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Patient EMR vitals logged successfully!',
        ]);

        return back();
    }

    public function prescriptions(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        $prescriptions = Prescription::where('doctor_id', $doctor->id)->with('patient.user')->orderBy('issued_at', 'desc')->paginate(15);
        $patients = Patient::whereHas('appointments', fn($q) => $q->where('doctor_id', $doctor->id))->with('user')->get();
        
        return view('doctor.prescriptions', compact('doctor', 'prescriptions', 'patients'));
    }

    public function storePrescription(Request $request): RedirectResponse
    {
        $doctor = $this->getDoctor($request);

        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'medication_name' => ['required', 'string', 'max:255'],
            'dosage' => ['required', 'string', 'max:100'],
            'frequency' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'string', 'max:100'],
            'instructions' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'advice' => ['nullable', 'string'],
            'follow_up_date' => ['nullable', 'date', 'after:today'],
        ]);

        Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'medication_name' => $request->medication_name,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'duration' => $request->duration,
            'instructions' => $request->instructions,
            'diagnosis' => $request->diagnosis,
            'advice' => $request->advice,
            'follow_up_date' => $request->follow_up_date,
            'digital_signature' => 'Signed by ' . $doctor->full_name,
            'issued_at' => now(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Prescription created successfully!',
        ]);

        return back();
    }

    public function reports(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        $reports = MedicalReport::where('doctor_id', $doctor->id)->with('patient.user')->orderBy('reported_at', 'desc')->paginate(15);
        $patients = Patient::whereHas('appointments', fn($q) => $q->where('doctor_id', $doctor->id))->with('user')->get();
        return view('doctor.reports', compact('doctor', 'reports', 'patients'));
    }

    public function approveReport(Request $request, int $id): RedirectResponse
    {
        $doctor = $this->getDoctor($request);
        $report = MedicalReport::where('doctor_id', $doctor->id)->findOrFail($id);

        $request->validate([
            'remarks' => ['nullable', 'string'],
        ]);

        $report->update([
            'status' => 'final',
            'summary' => $report->summary . "\n\nDoctor Remarks: " . $request->remarks,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Diagnostic report approved and finalized!',
        ]);

        return back();
    }

    public function uploadReport(Request $request): RedirectResponse
    {
        $doctor = $this->getDoctor($request);

        $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'title' => ['required', 'string', 'max:255'],
            'report_type' => ['required', 'string', 'in:lab,radiology,clinical,discharge'],
            'summary' => ['required', 'string'],
        ]);

        MedicalReport::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctor->id,
            'title' => $request->title,
            'report_type' => $request->report_type,
            'summary' => $request->summary,
            'status' => 'final',
            'reported_at' => now(),
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Diagnostic report uploaded successfully!',
        ]);

        return back();
    }

    public function messages(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        
        // Simple mock inbox matching sender-receiver threads
        $messages = Message::where('sender_id', $request->user()->id)
            ->orWhere('receiver_id', $request->user()->id)
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get list of possible recipients (all patients, admins, receptionists)
        $patients = Patient::whereHas('appointments', fn($q) => $q->where('doctor_id', $doctor->id))->with('user')->get();
        
        return view('doctor.messages', compact('doctor', 'messages', 'patients'));
    }

    public function sendMessage(Request $request): RedirectResponse
    {
        $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'body' => ['required', 'string'],
        ]);

        Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
            'is_read' => false,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Message dispatched successfully!',
        ]);

        return back();
    }

    public function settings(Request $request): View
    {
        $doctor = $this->getDoctor($request);
        return view('doctor.settings', compact('doctor'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $doctor = $this->getDoctor($request);
        $user = $request->user();

        if ($request->has('profile_update')) {
            $request->validate([
                'phone' => ['required', 'string', 'max:20'],
                'consultation_fee' => ['required', 'numeric', 'min:0'],
                'online_fee' => ['required', 'numeric', 'min:0'],
                'bio' => ['nullable', 'string'],
            ]);

            $user->update([
                'phone' => $request->phone,
            ]);

            $doctor->update([
                'phone' => $request->phone,
                'consultation_fee' => $request->consultation_fee,
                'online_fee' => $request->online_fee,
                'bio' => $request->bio,
            ]);

            $request->session()->flash('toast', [
                'type' => 'success',
                'message' => 'Credentials and profile updated!',
            ]);
        }

        return back();
    }
}
