<?php

namespace App\Jobs;

use App\Services\DashboardMetricService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class GenerateDailyHospitalSnapshot implements ShouldQueue
{
    use Queueable;

    public function handle(DashboardMetricService $metrics): void
    {
        Cache::put('AarogyaCare.daily_snapshot', $metrics->snapshot('hospital-admin'), now()->addDay());
    }
}
