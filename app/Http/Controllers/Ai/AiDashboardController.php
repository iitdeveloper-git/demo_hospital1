<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Models\ClinicalAlert;
use App\Models\AiUsageLog;
use App\Models\AiFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AiDashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();

        // 1. Gather stats
        $todayRequests = AiUsageLog::where('created_at', '>=', $today)->count();
        
        $doctorUsage = AiUsageLog::whereHas('user', function ($q) {
            $q->whereHas('role', function ($r) {
                $r->where('slug', 'doctor');
            });
        })->count();

        $patientUsage = AiUsageLog::whereHas('user', function ($q) {
            $q->whereHas('role', function ($r) {
                $r->where('slug', 'patient');
            });
        })->count();

        $riskAlerts = ClinicalAlert::where('is_resolved', false)->where('alert_type', 'bp')->count();
        $drugAlerts = ClinicalAlert::where('is_resolved', false)->where('alert_type', 'drug_interaction')->count();
        $labAlerts = ClinicalAlert::where('is_resolved', false)->where('alert_type', 'critical_lab')->count();
        $criticalCases = ClinicalAlert::where('is_resolved', false)->where('severity', 'critical')->count();

        // Feedbacks
        $helpfulCount = AiFeedback::where('rating', 1)->count();
        $unhelpfulCount = AiFeedback::where('rating', -1)->count();
        $totalFeedback = max(1, $helpfulCount + $unhelpfulCount);
        $accuracyPercentage = round(($helpfulCount / $totalFeedback) * 100);

        // Daily requests graph data
        $dailyRequests = AiUsageLog::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        // Latency logs
        $averageLatency = round(AiUsageLog::avg('latency_ms') ?? 180);

        return view('ai.dashboard', compact(
            'todayRequests',
            'doctorUsage',
            'patientUsage',
            'riskAlerts',
            'drugAlerts',
            'labAlerts',
            'criticalCases',
            'accuracyPercentage',
            'dailyRequests',
            'averageLatency'
        ));
    }
}
