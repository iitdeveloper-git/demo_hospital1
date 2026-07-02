<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\MedicalReport;
use App\Models\AiProviderSetting;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\AiPromptTemplate;
use App\Models\ClinicalAlert;
use App\Models\DrugInteractionLog;
use App\Models\PatientRiskScore;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AiModuleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed AI Provider Settings
        $providers = [
            [
                'provider' => 'gemini',
                'model' => 'gemini-1.5-flash',
                'temperature' => 0.70,
                'token_limit' => 4096,
                'system_prompt' => 'You are Antigravity CDSS, a secure medical co-pilot. You provide advisory support only. Never make final diagnoses. Always include safety disclaimers.',
                'rate_limit' => 60,
                'fallback_strategy' => 'mock',
                'is_active' => true,
            ],
            [
                'provider' => 'openai',
                'model' => 'gpt-4o',
                'temperature' => 0.50,
                'token_limit' => 2048,
                'system_prompt' => 'You are an AI Clinical Assistant. You provide evidence-based guidance only. Licensed professionals make final decisions.',
                'rate_limit' => 60,
                'fallback_strategy' => 'gemini',
                'is_active' => false,
            ],
            [
                'provider' => 'ollama',
                'model' => 'llama3',
                'temperature' => 0.70,
                'token_limit' => 2048,
                'system_prompt' => 'Local clinical assistant advisory model.',
                'rate_limit' => 30,
                'fallback_strategy' => 'mock',
                'is_active' => false,
            ]
        ];

        foreach ($providers as $p) {
            AiProviderSetting::query()->updateOrCreate(['provider' => $p['provider']], $p);
        }

        // 2. Seed Prompt Templates
        $templates = [
            [
                'name' => 'Symptom Checker Template',
                'slug' => 'symptom-checker',
                'version' => '1.0.0',
                'system_prompt' => 'You are an expert diagnostic triage assistant.',
                'user_prompt_template' => 'Patient has symptoms: {symptoms} for {duration_days} days. Severity is {severity}. History: {medical_history}. Generate possible conditions, urgency, department, and specialist.',
                'is_active' => true,
            ],
            [
                'name' => 'Drug Interaction Analyser',
                'slug' => 'drug-interaction',
                'version' => '1.0.0',
                'system_prompt' => 'Review potential interactions between medicines.',
                'user_prompt_template' => 'Analyze interaction between {drug_a} and {drug_b} given history: {medical_history}.',
                'is_active' => true,
            ]
        ];

        foreach ($templates as $t) {
            AiPromptTemplate::query()->updateOrCreate(['slug' => $t['slug']], $t);
        }

        // Gather relations
        $users = User::all();
        $patients = Patient::all();
        $reports = MedicalReport::all();

        if ($users->isEmpty() || $patients->isEmpty()) {
            return;
        }

        // 3. Seed 1000 AI Conversations
        $conversations = [];
        $now = now();

        $roles = ['doctor', 'patient', 'pharmacist', 'receptionist', 'lab-technician'];
        $titles = [
            'Symptom assessment for persistent cough',
            'Drug-drug contraindication review: Warfarin & Aspirin',
            'Abnormal CBC report clinical insights',
            'Patient timeline synthesis',
            'Lisinopril allergy check',
            'Triage recommendation query',
            'ICU bed capacity planning advisor',
            'OT scheduling delay insights',
        ];

        // Seed in bulk to be high performance
        $conversationsData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $user = $users->random();
            $conversationsData[] = [
                'user_id' => $user->id,
                'title' => $titles[$i % count($titles)] . " #$i",
                'role' => $roles[$i % count($roles)],
                'is_pinned' => $i % 20 === 0,
                'metadata' => json_encode(['source' => 'system-seeder']),
                'created_at' => $now->copy()->subMinutes($i * 5),
                'updated_at' => $now->copy()->subMinutes($i * 5),
            ];
        }
        
        // Chunk insert
        foreach (array_chunk($conversationsData, 200) as $chunk) {
            DB::table('ai_conversations')->insert($chunk);
        }

        // Seed messages for first 200 conversations
        $conversationIds = AiConversation::pluck('id')->toArray();
        $messagesData = [];
        foreach (array_slice($conversationIds, 0, 200) as $cId) {
            $messagesData[] = [
                'conversation_id' => $cId,
                'sender_role' => 'user',
                'message_content' => 'Please provide clinical advice on the recorded symptoms.',
                'file_path' => null,
                'token_count' => 45,
                'latency_ms' => 0,
                'created_at' => $now->copy()->subMinutes(10),
                'updated_at' => $now->copy()->subMinutes(10),
            ];
            $messagesData[] = [
                'conversation_id' => $cId,
                'sender_role' => 'ai',
                'message_content' => '**Clinical Advisor Decision Support Notice**: Based on initial parameters, potential causes include respiratory irritation. Follow-up consultation is advised. Disclaimer: This is not a diagnosis.',
                'file_path' => null,
                'token_count' => 120,
                'latency_ms' => 320,
                'created_at' => $now->copy()->subMinutes(9),
                'updated_at' => $now->copy()->subMinutes(9),
            ];
        }

        foreach (array_chunk($messagesData, 200) as $chunk) {
            DB::table('ai_messages')->insert($chunk);
        }

        // 4. Seed 500 Risk Assessments
        $riskAssessments = [];
        $riskTypes = ['diabetes', 'hypertension', 'heart', 'kidney', 'stroke', 'fall', 'bmi', 'readmission'];
        $trends = ['up', 'down', 'stable'];

        for ($i = 1; $i <= 500; $i++) {
            $patient = $patients->random();
            $riskAssessments[] = [
                'patient_id' => $patient->id,
                'risk_type' => $riskTypes[$i % count($riskTypes)],
                'score' => fake()->randomFloat(2, 5, 95),
                'trend_direction' => $trends[$i % count($trends)],
                'assessment_date' => now()->subDays($i % 30)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($riskAssessments, 100) as $chunk) {
            DB::table('patient_risk_scores')->insert($chunk);
        }

        // 5. Seed 1000 Clinical Alerts
        $alerts = [];
        $alertTypes = ['critical_lab', 'bp', 'oxygen', 'drug_interaction', 'allergy', 'missed_appointment', 'medicine_reminder'];
        $severities = ['info', 'warning', 'critical'];
        $messagesList = [
            'Critical Lab Alert: Blood Sugar exceeds 250 mg/dL.',
            'Hypertension Alert: BP vitals are registered at 145/95 mmHg.',
            'Hypoxia Warning: SpO2 level detected below 92%.',
            'Drug Interaction Warning: High risk of bleeding with Warfarin and Aspirin co-prescription.',
            'Allergy Contraindication: Penicillin allergy logged on profile.',
            'Scheduling reminder: Missed follow-up consult with cardiology specialist.',
            'Treatment Reminder: Anticoagulant dosage reminder due at 09:00 PM.',
        ];

        for ($i = 1; $i <= 1000; $i++) {
            $patient = $patients->random();
            $typeIdx = $i % count($alertTypes);
            $alerts[] = [
                'patient_id' => $patient->id,
                'alert_type' => $alertTypes[$typeIdx],
                'severity' => $typeIdx === 2 || $typeIdx === 3 ? 'critical' : $severities[$i % count($severities)],
                'message' => $messagesList[$typeIdx] . " (Assess Ref #$i)",
                'is_resolved' => $i % 4 === 0,
                'resolved_by' => $i % 4 === 0 ? $users->random()->id : null,
                'created_at' => $now->copy()->subHours($i),
                'updated_at' => $now->copy()->subHours($i),
            ];
        }

        foreach (array_chunk($alerts, 200) as $chunk) {
            DB::table('clinical_alerts')->insert($chunk);
        }

        // 6. Seed 100 Drug Interaction Logs
        $interactions = [];
        $drugsList = [
            ['Warfarin', 'Aspirin', 'major', 'Concomitant use increases the risk of serious bleeding events due to additive antihemostatic effects.'],
            ['Simvastatin', 'Amlodipine', 'moderate', 'Amlodipine increases Simvastatin plasma concentration, elevating myopathy and rhabdomyolysis risks.'],
            ['Metformin', 'Contrast Media', 'major', 'Iodinated contrast media may lead to acute renal failure and lactic acidosis. Suspend metformin 48h prior.'],
            ['Lisinopril', 'Spironolactone', 'moderate', 'Additive risk of severe hyperkalemia. Frequent monitoring of serum potassium levels is recommended.'],
            ['Ibuprofen', 'Aspirin', 'minor', 'Ibuprofen may interfere with the cardioprotective antiplatelet effect of low-dose aspirin.'],
        ];

        for ($i = 1; $i <= 100; $i++) {
            $patient = $patients->random();
            $d = $drugsList[$i % count($drugsList)];
            $interactions[] = [
                'patient_id' => $patient->id,
                'drug_a' => $d[0],
                'drug_b' => $d[1],
                'severity' => $d[2],
                'interaction_description' => $d[3],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($interactions, 50) as $chunk) {
            DB::table('drug_interaction_logs')->insert($chunk);
        }
    }
}
