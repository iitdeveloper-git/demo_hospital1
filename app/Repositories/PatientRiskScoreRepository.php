<?php

namespace App\Repositories;

use App\Models\PatientRiskScore;
use Illuminate\Database\Eloquent\Collection;

class PatientRiskScoreRepository
{
    public function getRiskScoresForPatient(int $patientId): Collection
    {
        return PatientRiskScore::where('patient_id', $patientId)
            ->orderBy('assessment_date', 'desc')
            ->get();
    }
}
