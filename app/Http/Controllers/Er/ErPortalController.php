<?php

namespace App\Http\Controllers\Er;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use App\Models\DisasterModeLog;
use App\Models\Doctor;
use App\Models\EmergencyAlert;
use App\Models\EmergencyCase;
use App\Models\HospitalBed;
use App\Models\IcuPatient;
use App\Models\OtBooking;
use App\Models\Patient;
use App\Models\TriageAssessment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ErPortalController extends Controller
{
    public function dashboard(): View
    {
        $metrics = [
            'er_today' => EmergencyCase::whereDate('created_at', now()->toDateString())->count(),
            'critical' => EmergencyCase::where('priority_level', 'red')->count(),
            'ambulances' => Ambulance::where('availability', true)->count(),
            'ambulances_duty' => Ambulance::where('availability', false)->count(),
            'icu_beds_free' => HospitalBed::where('status', 'available')->whereHas('ward', fn($q) => $q->where('name', 'like', '%ICU%'))->count(),
            'icu_patients' => IcuPatient::count(),
            'ot_scheduled' => OtBooking::where('status', 'scheduled')->count(),
            'code_blue' => EmergencyAlert::where('type', 'Code Blue')->where('status', 'active')->count(),
        ];

        return view('er.dashboard', compact('metrics'));
    }

    public function patients(Request $request): View
    {
        $patients = Patient::with('user')->get();
        $query = EmergencyCase::with('patient.user');
        if ($request->filled('search')) {
            $query->where('case_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('patient.user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }
        $cases = $query->paginate(15);
        return view('er.patients', compact('patients', 'cases'));
    }

    public function storePatient(Request $request): RedirectResponse
    {
        $request->validate([
            'patient_id' => ['nullable', 'exists:patients,id'],
            'arrival_method' => ['required', 'string'],
            'priority_level' => ['required', 'string'],
        ]);

        $case = EmergencyCase::create([
            'case_number' => 'ER-' . strtoupper(Str::random(6)),
            'patient_id' => $request->patient_id,
            'arrival_method' => $request->arrival_method,
            'priority_level' => $request->priority_level,
            'status' => 'triage',
        ]);

        // Automatically trigger triage log stub
        TriageAssessment::create([
            'emergency_case_id' => $case->id,
            'status' => $request->priority_level,
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Emergency Case registered: ' . $case->case_number,
        ]);

        return back();
    }

    public function triage(): View
    {
        $assessments = TriageAssessment::with('emergencyCase.patient.user')->orderBy('id', 'desc')->paginate(15);
        return view('er.triage', compact('assessments'));
    }

    public function storeTriage(Request $request): RedirectResponse
    {
        $request->validate([
            'triage_id' => ['required', 'exists:triage_assessments,id'],
            'heart_rate' => ['required', 'integer'],
            'blood_pressure' => ['required', 'string'],
            'temperature' => ['required', 'numeric'],
            'oxygen_saturation' => ['required', 'integer'],
        ]);

        $ta = TriageAssessment::findOrFail($request->triage_id);
        $ta->update([
            'heart_rate' => $request->heart_rate,
            'blood_pressure' => $request->blood_pressure,
            'temperature' => $request->temperature,
            'oxygen_saturation' => $request->oxygen_saturation,
        ]);

        return back()->with('toast', [
            'type' => 'success',
            'message' => 'Triage Vitals logged successfully.',
        ]);
    }

    public function ambulance(): View
    {
        $ambulances = Ambulance::paginate(15);
        return view('er.ambulance', compact('ambulances'));
    }

    public function icu(): View
    {
        $beds = HospitalBed::whereHas('ward', fn($q) => $q->where('name', 'like', '%ICU%'))->get();
        $patients = IcuPatient::with(['patient.user', 'bed'])->orderBy('id', 'desc')->paginate(15);
        return view('er.icu', compact('beds', 'patients'));
    }

    public function beds(): View
    {
        $beds = HospitalBed::with('ward')->paginate(15);
        return view('er.beds', compact('beds'));
    }

    public function operationTheatre(): View
    {
        $doctors = Doctor::all();
        $cases = EmergencyCase::where('status', '!=', 'discharged')->get();
        $bookings = OtBooking::with(['emergencyCase.patient.user', 'surgeon'])->orderBy('id', 'desc')->paginate(15);
        return view('er.operation-theatre', compact('doctors', 'cases', 'bookings'));
    }

    public function storeOt(Request $request): RedirectResponse
    {
        $request->validate([
            'emergency_case_id' => ['required', 'exists:emergency_cases,id'],
            'surgeon_id' => ['required', 'exists:doctors,id'],
            'ot_number' => ['required', 'string'],
        ]);

        OtBooking::create([
            'emergency_case_id' => $request->emergency_case_id,
            'surgeon_id' => $request->surgeon_id,
            'ot_number' => $request->ot_number,
            'status' => 'scheduled',
        ]);

        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'OT Booking registered successfully.',
        ]);

        return back();
    }

    public function emergencyAlerts(): View
    {
        $alerts = EmergencyAlert::orderBy('id', 'desc')->paginate(15);
        return view('er.emergency-alerts', compact('alerts'));
    }

    public function triggerCodeBlue(Request $request): RedirectResponse
    {
        EmergencyAlert::create([
            'title' => 'Code Blue Alert - Room ' . ($request->room ?? 'ER Trauma 1'),
            'type' => 'Code Blue',
            'status' => 'active',
        ]);

        return back()->with('toast', [
            'type' => 'danger',
            'message' => 'CODE BLUE triggered! Broadcast dispatched to response team.',
        ]);
    }

    public function triggerDisaster(Request $request): RedirectResponse
    {
        DisasterModeLog::create([
            'description' => 'Mass Casualty Incident Mode Activated - Staff Recalled',
            'staff_recalled_count' => 45,
            'status' => 'active',
        ]);

        return back()->with('toast', [
            'type' => 'danger',
            'message' => 'DISASTER MODE Activated. Priority staff recall triggered.',
        ]);
    }

    public function reports(): View
    {
        return view('er.reports');
    }
}
