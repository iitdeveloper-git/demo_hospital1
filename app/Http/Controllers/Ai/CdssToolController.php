<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\ClinicalAlert;
use App\Models\AiProviderSetting;
use App\Models\AiPromptTemplate;
use App\Models\DrugInteractionLog;
use App\Models\PatientRiskScore;
use App\Models\MedicalReport;
use App\Models\Prescription;
use App\Services\Ai\CdssService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CdssToolController extends Controller
{
    protected CdssService $cdssService;

    public function __construct(CdssService $cdssService)
    {
        $this->cdssService = $cdssService;
    }

    public function patientSummary(Request $request): View
    {
        $patients = Patient::with('user')->get();
        $selectedPatientId = $request->input('patient_id') ?? ($patients->first()?->id);
        
        $summaryData = [];
        if ($selectedPatientId) {
            $summaryData = $this->cdssService->generatePatientSummary((int)$selectedPatientId);
        }

        return view('ai.patient-summary', compact('patients', 'selectedPatientId', 'summaryData'));
    }

    public function symptomChecker(): View
    {
        $patients = Patient::with('user')->get();
        return view('ai.symptom-checker', compact('patients'));
    }

    public function postSymptomChecker(Request $request): View
    {
        $data = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'symptoms' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'severity' => 'required|in:low,medium,high',
            'age' => 'nullable|integer|min:0',
            'gender' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        $res = $this->cdssService->checkSymptoms($data);
        $patients = Patient::with('user')->get();
        $assessment = $res['assessment'];
        $aiResponse = $res['ai_response'];

        return view('ai.symptom-checker', compact('patients', 'assessment', 'aiResponse'));
    }

    public function labInsights(): View
    {
        $abnormalReports = MedicalReport::with('patient.user')
            ->where('report_type', 'lab')
            ->orderBy('reported_at', 'desc')
            ->paginate(10);

        return view('ai.lab-insights', compact('abnormalReports'));
    }

    public function radiologyInsights(): View
    {
        $reports = MedicalReport::with('patient.user')
            ->where('report_type', 'radiology')
            ->orderBy('reported_at', 'desc')
            ->paginate(10);

        return view('ai.radiology-insights', compact('reports'));
    }

    public function prescriptionReview(): View
    {
        $prescriptions = Prescription::with(['patient.user', 'doctor.user'])->paginate(15);
        return view('ai.prescription-review', compact('prescriptions'));
    }

    public function drugInteractions(): View
    {
        $medicines = Medicine::all();
        $logs = DrugInteractionLog::orderBy('created_at', 'desc')->take(10)->get();
        return view('ai.drug-interactions', compact('medicines', 'logs'));
    }

    public function postDrugInteractions(Request $request): View
    {
        $request->validate([
            'drug_a' => 'required|string',
            'drug_b' => 'required|string',
        ]);

        $drugA = $request->input('drug_a');
        $drugB = $request->input('drug_b');

        $res = $this->cdssService->checkDrugInteractions($drugA, $drugB);
        $medicines = Medicine::all();
        $logs = DrugInteractionLog::orderBy('created_at', 'desc')->take(10)->get();
        
        $analysis = $res['analysis'];
        $severity = $res['severity'];

        return view('ai.drug-interactions', compact('medicines', 'logs', 'analysis', 'severity', 'drugA', 'drugB'));
    }

    public function riskScore(Request $request): View
    {
        $patients = Patient::with('user')->get();
        $selectedPatientId = $request->input('patient_id') ?? ($patients->first()?->id);
        
        $riskScores = [];
        if ($selectedPatientId) {
            $riskScores = PatientRiskScore::where('patient_id', $selectedPatientId)
                ->orderBy('assessment_date', 'desc')
                ->get();
        }

        return view('ai.risk-score', compact('patients', 'selectedPatientId', 'riskScores'));
    }

    public function alerts(): View
    {
        $alerts = ClinicalAlert::with('patient.user')
            ->orderBy('is_resolved', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('ai.alerts', compact('alerts'));
    }

    public function resolveAlert(int $id): RedirectResponse
    {
        $alert = ClinicalAlert::findOrFail($id);
        $alert->update([
            'is_resolved' => true,
            'resolved_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Clinical alert marked resolved successfully.');
    }

    public function settings(): View
    {
        $settings = AiProviderSetting::all();
        return view('ai.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'provider' => 'required|exists:ai_provider_settings,provider',
            'model' => 'required|string',
            'temperature' => 'required|numeric|min:0|max:1',
            'token_limit' => 'required|integer|min:1',
            'system_prompt' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $provider = $request->input('provider');
        $setting = AiProviderSetting::where('provider', $provider)->firstOrFail();

        // If toggling active, deactivate others
        if ($request->has('is_active')) {
            AiProviderSetting::query()->update(['is_active' => false]);
            $setting->is_active = true;
        }

        $setting->update([
            'model' => $request->input('model'),
            'temperature' => $request->input('temperature'),
            'token_limit' => $request->input('token_limit'),
            'system_prompt' => $request->input('system_prompt'),
        ]);

        return redirect()->back()->with('success', 'AI provider settings updated successfully.');
    }

    public function prompts(): View
    {
        $prompts = AiPromptTemplate::all();
        return view('ai.prompts', compact('prompts'));
    }

    public function updatePrompt(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => 'required|exists:ai_prompt_templates,id',
            'system_prompt' => 'required|string',
            'user_prompt_template' => 'required|string',
        ]);

        $prompt = AiPromptTemplate::findOrFail($request->input('id'));
        $prompt->update([
            'system_prompt' => $request->input('system_prompt'),
            'user_prompt_template' => $request->input('user_prompt_template'),
        ]);

        return redirect()->back()->with('success', 'Prompt template saved successfully.');
    }
}
