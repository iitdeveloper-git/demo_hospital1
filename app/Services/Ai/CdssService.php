<?php

namespace App\Services\Ai;

use App\Models\Patient;
use App\Models\MedicalReport;
use App\Models\Prescription;
use App\Models\Bill;
use App\Models\ClinicalAlert;
use App\Models\DrugInteractionLog;
use App\Models\PatientRiskScore;
use App\Models\SymptomAssessment;
use Illuminate\Support\Facades\DB;

class CdssService
{
    protected AiManagerService $aiManager;

    public function __construct(AiManagerService $aiManager)
    {
        $this->aiManager = $aiManager;
    }

    public function checkSymptoms(array $data): array
    {
        $symptoms = $data['symptoms'] ?? '';
        $duration = (int)($data['duration_days'] ?? 1);
        $severity = $data['severity'] ?? 'medium';
        $age = isset($data['age']) ? (int)$data['age'] : null;
        $gender = $data['gender'] ?? '';
        $history = $data['medical_history'] ?? '';
        $patientId = $data['patient_id'] ?? null;

        $prompt = "Symptom check query: Patient (Age: {$age}, Gender: {$gender}) reports '{$symptoms}' for {$duration} days. Severity: {$severity}. History: {$history}. Suggest conditions, urgency level, suggested department, specialist.";

        $messages = [
            ['role' => 'system', 'content' => 'You are a clinical decision support co-pilot. Generate clinical guidance only. Always add medical safety disclaimers.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $aiRes = $this->aiManager->generateResponse($messages);
        $text = $aiRes['text'];

        // Determine department and urgency based on simple text heuristics
        $urgency = 'routine';
        if (str_contains(strtolower($text), 'emergency') || str_contains(strtolower($text), 'critical') || str_contains(strtolower($text), 'immediate')) {
            $urgency = 'emergency';
        } elseif (str_contains(strtolower($text), 'urgent') || str_contains(strtolower($text), 'soon')) {
            $urgency = 'urgent';
        }

        $dept = 'General Medicine';
        if (str_contains(strtolower($text), 'cardi')) $dept = 'Cardiology';
        elseif (str_contains(strtolower($text), 'neuro')) $dept = 'Neurology';
        elseif (str_contains(strtolower($text), 'ortho')) $dept = 'Orthopedics';
        elseif (str_contains(strtolower($text), 'pediatr')) $dept = 'Pediatrics';

        $assessment = SymptomAssessment::create([
            'patient_id' => $patientId,
            'symptoms' => $symptoms,
            'duration_days' => $duration,
            'severity' => $severity,
            'age' => $age,
            'gender' => $gender,
            'medical_history' => $history,
            'possible_conditions' => [
                'ai_analysis' => $text,
            ],
            'urgency_level' => $urgency,
            'suggested_department' => $dept,
            'suggested_specialist' => 'Specialist Consultant',
        ]);

        return [
            'assessment' => $assessment,
            'ai_response' => $text,
        ];
    }

    public function checkDrugInteractions(string $drugA, string $drugB, ?int $patientId = null): array
    {
        $prompt = "Identify potential drug interaction between Drug A: {$drugA} and Drug B: {$drugB}. Provide severity, mechanism, and recommendations.";

        $messages = [
            ['role' => 'system', 'content' => 'Identify potential contraindications. Mark severity as minor, moderate, or major.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $aiRes = $this->aiManager->generateResponse($messages);
        $text = $aiRes['text'];

        $severity = 'moderate';
        if (str_contains(strtolower($text), 'major') || str_contains(strtolower($text), 'critical') || str_contains(strtolower($text), 'danger')) {
            $severity = 'major';
        } elseif (str_contains(strtolower($text), 'minor') || str_contains(strtolower($text), 'low')) {
            $severity = 'minor';
        }

        $log = DrugInteractionLog::create([
            'patient_id' => $patientId,
            'drug_a' => $drugA,
            'drug_b' => $drugB,
            'severity' => $severity,
            'interaction_description' => $text,
        ]);

        // If interaction is major, create a clinical alert
        if ($severity === 'major' && $patientId) {
            ClinicalAlert::create([
                'patient_id' => $patientId,
                'alert_type' => 'drug_interaction',
                'severity' => 'critical',
                'message' => "Major interaction detected between {$drugA} and {$drugB}.",
                'is_resolved' => false,
            ]);
        }

        return [
            'log' => $log,
            'severity' => $severity,
            'analysis' => $text,
        ];
    }

    public function generatePatientSummary(int $patientId): array
    {
        $patient = Patient::with(['user'])->findOrFail($patientId);
        
        $history = MedicalReport::where('patient_id', $patientId)->orderBy('reported_at', 'desc')->get();
        $prescriptions = Prescription::where('patient_id', $patientId)->orderBy('issued_at', 'desc')->get();
        $bills = Bill::where('patient_id', $patientId)->orderBy('due_at', 'desc')->get();
        
        // Let's build a timeline summary prompt
        $historySummary = $history->take(3)->map(fn($h) => "{$h->reported_at}: {$h->title} - {$h->summary}")->implode("; ");
        $medsSummary = $prescriptions->take(4)->map(fn($p) => "{$p->medication_name} ({$p->dosage}) - {$p->frequency}")->implode("; ");

        $prompt = "Generate a brief, highly structured clinical summary and patient timeline for:
Name: {$patient->user->name}
Gender: {$patient->gender}
DOB: {$patient->date_of_birth}
Allergies/Alerts: " . json_encode($patient->medical_alerts) . "
Recent Reports: {$historySummary}
Current Medications: {$medsSummary}";

        $messages = [
            ['role' => 'system', 'content' => 'Provide a clean, structured patient timeline. Be concise. Include emergency warning notes if relevant.'],
            ['role' => 'user', 'content' => $prompt]
        ];

        $aiRes = $this->aiManager->generateResponse($messages);

        return [
            'patient' => $patient,
            'history' => $history,
            'prescriptions' => $prescriptions,
            'bills' => $bills,
            'ai_summary' => $aiRes['text'],
        ];
    }
}
