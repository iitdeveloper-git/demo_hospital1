<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Patient;

class DashboardMetricService
{
    public function snapshot(string $role): array
    {
        return [
            'cards' => [
                ['label' => 'Patients', 'value' => Patient::query()->count(), 'trend' => '+12.4%', 'icon' => 'fa-user-injured'],
                ['label' => 'Doctors', 'value' => Doctor::query()->count(), 'trend' => '+4.1%', 'icon' => 'fa-user-doctor'],
                ['label' => 'Appointments', 'value' => Appointment::query()->count(), 'trend' => '+18.8%', 'icon' => 'fa-calendar-check'],
                ['label' => 'Revenue', 'value' => '$'.number_format((float) Bill::query()->sum('amount')), 'trend' => '+9.7%', 'icon' => 'fa-file-invoice-dollar'],
            ],
            'chart' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'admissions' => [42, 58, 49, 71, 63, 76, 69],
                'discharges' => [31, 45, 39, 52, 48, 58, 54],
            ],
            'alerts' => [
                ['title' => 'Critical stock watch', 'body' => Medicine::query()->whereColumn('stock', '<=', 'reorder_level')->count().' medicines need replenishment.'],
                ['title' => 'AI triage queue', 'body' => Appointment::query()->where('triage_score', '>=', 8)->count().' patients marked high priority.'],
            ],
            'role' => $role,
        ];
    }
}
