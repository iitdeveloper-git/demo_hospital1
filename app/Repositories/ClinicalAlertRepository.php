<?php

namespace App\Repositories;

use App\Models\ClinicalAlert;
use Illuminate\Database\Eloquent\Collection;

class ClinicalAlertRepository
{
    public function getActiveAlerts(): Collection
    {
        return ClinicalAlert::with('patient.user')
            ->where('is_resolved', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
