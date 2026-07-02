<?php

namespace App\Services\Ai\Providers;

use App\Services\Ai\Contracts\AiProviderInterface;

class MockAiProvider implements AiProviderInterface
{
    public function generate(array $messages, array $options = []): array
    {
        $start = microtime(true);
        $lastMessage = end($messages)['content'] ?? '';
        
        $responseText = $this->generateMockResponse($lastMessage);
        
        $latency = (int)((microtime(true) - $start) * 1000);

        return [
            'text' => $responseText,
            'prompt_tokens' => strlen($lastMessage) / 4,
            'completion_tokens' => strlen($responseText) / 4,
            'latency_ms' => $latency > 0 ? $latency : 150,
        ];
    }

    private function generateMockResponse(string $prompt): string
    {
        $promptLower = strtolower($prompt);

        // Symptom checker matching
        if (str_contains($promptLower, 'symptom') || str_contains($promptLower, 'cough') || str_contains($promptLower, 'fever') || str_contains($promptLower, 'pain')) {
            return "### CLINICAL DECISION SUPPORT SYSTEM ADVISORY\n" .
                   "**Safety Notice:** This is an automated clinical guideline helper for licensed professionals. It does NOT constitute a final medical diagnosis.\n\n" .
                   "#### Preliminary Evaluation Summary:\n" .
                   "- **Suggested Potential Conditions:** Acute Bronchitis, Mild Upper Respiratory Tract Infection, Gastroesophageal Reflux Disease (GERD) if coughing is postprandial.\n" .
                   "- **Urgency Level:** Routine to Moderate. Urgent evaluation required if symptoms escalate (e.g., dyspnea, hemoptysis).\n" .
                   "- **Recommended Clinical Department:** Pulmonology / General Medicine\n" .
                   "- **Suggested Specialist consult:** Dr. Aanya Sharma (General Medicine)\n\n" .
                   "#### Red Flag warnings:\n" .
                   "> [!WARNING]\n" .
                   "> Seek emergency services immediately if the patient experiences: shortness of breath, chest pressure or pain, high persistent fever (>103°F/39.4°C), or confusion.";
        }

        // Drug interaction matching
        if (str_contains($promptLower, 'warfarin') || str_contains($promptLower, 'aspirin') || str_contains($promptLower, 'interaction') || str_contains($promptLower, 'drug')) {
            return "### CLINICAL DECISION SUPPORT SYSTEM ADVISORY\n" .
                   "**Safety Notice:** Advisory contraindication logs generated for review. Final treatment changes must be approved by the attending physician.\n\n" .
                   "#### Detected Contraindications:\n" .
                   "- **Severity level:** **CRITICAL / MAJOR**\n" .
                   "- **Interacting agents:** Warfarin Sodium + Aspirin (Acetylsalicylic Acid)\n" .
                   "- **Mechanism:** Additive antihemostatic effects. Concurrent therapy increases the risk of serious upper gastrointestinal bleeding and systemic hemorrhaging.\n\n" .
                   "#### Suggested Alternatives / Actions:\n" .
                   "1. Monitor Prothrombin Time (PT) and International Normalized Ratio (INR) closely.\n" .
                   "2. Consider alternative non-NSAID analgesics (e.g. Paracetamol) if pain management is primary goal.\n" .
                   "3. Introduce a proton pump inhibitor (PPI) if dual therapy is absolutely unavoidable.";
        }

        // Lab values matching
        if (str_contains($promptLower, 'cbc') || str_contains($promptLower, 'blood') || str_contains($promptLower, 'sugar') || str_contains($promptLower, 'lab')) {
            return "### CLINICAL DECISION SUPPORT SYSTEM ADVISORY\n" .
                   "**Safety Notice:** Lab value indicators are derived automatically. Direct physician review of primary LIMS records is mandatory.\n\n" .
                   "#### High-Risk Clinical Findings:\n" .
                   "- **Fasting Blood Glucose:** 142 mg/dL (**High** - Impaired Fasting Glucose/Pre-diabetes threshold).\n" .
                   "- **HbA1c:** 6.4% (**High** - Prediabetes range. Recommended lifestyle management and repeat test in 3 months).\n" .
                   "- **Total Cholesterol:** 245 mg/dL (**High** - Hypercholesterolemia. Suggest lipid profile fraction monitoring).\n\n" .
                   "#### Suggested Follow-up:\n" .
                   "- Schedule diabetes management counseling.\n" .
                   "- Review dietary plans and increase daily cardiovascular exercise.";
        }

        // Default response
        return "### AarogyaCare Clinical Co-Pilot (CDSS)\n" .
               "*This response was generated dynamically by the active AI assistant co-pilot.* \n\n" .
               "**Assessment & Recommendations:**\n" .
               "- Based on the submitted patient record, all active vitals (BP, Heart Rate, SpO2) are stable.\n" .
               "- Ensure all allergies (e.g. Penicillin) are flagged prominently in the Electronic Health Record (EHR).\n" .
               "- Scheduled appointments and pending lab orders have been cross-referenced successfully.\n\n" .
               "--- \n" .
               "**Disclaimer:** AI-generated advice is strictly advisory. Verify all clinical metrics, drug interactions, and diagnostics independently prior to prescribing treatments.";
    }
}
