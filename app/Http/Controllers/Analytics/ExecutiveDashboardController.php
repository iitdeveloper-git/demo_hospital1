<?php

namespace App\Http\Controllers\Analytics;

use App\Http\Controllers\Controller;
use App\Models\KpiTarget;
use App\Models\DashboardWidget;
use App\Models\AnalyticsSnapshot;
use App\Models\AuditEvent;
use App\Models\ScheduledReport;
use App\Models\SavedFilter;
use App\Services\Analytics\ForecastService;
use App\Services\Analytics\AuditLoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ExecutiveDashboardController extends Controller
{
    protected ForecastService $forecastService;
    protected AuditLoggerService $auditLogger;

    public function __construct(ForecastService $forecastService, AuditLoggerService $auditLogger)
    {
        $this->forecastService = $forecastService;
        $this->auditLogger = $auditLogger;
    }

    public function dashboard(): View
    {
        $widgets = DashboardWidget::where('user_id', Auth::id())->where('is_active', true)->get();
        $kpis = KpiTarget::orderBy('achievement_percentage', 'desc')->take(5)->get();
        
        $revenueSnapshot = AnalyticsSnapshot::where('category', 'revenue')->orderBy('snapshot_date', 'desc')->first();
        $metrics = $revenueSnapshot ? $revenueSnapshot->metrics_json : [
            'total_revenue' => 450000,
            'opd_count' => 850,
            'ipd_count' => 120,
            'expenses' => 120000,
        ];

        // Audit this access
        $this->auditLogger->log('read', 'analytics_dashboard');

        return view('analytics.dashboard', compact('widgets', 'kpis', 'metrics'));
    }

    public function revenue(): View
    {
        $snapshots = AnalyticsSnapshot::where('category', 'revenue')->orderBy('snapshot_date', 'desc')->take(12)->get();
        $this->auditLogger->log('read', 'revenue_analytics');
        return view('analytics.revenue', compact('snapshots'));
    }

    public function patients(): View
    {
        $this->auditLogger->log('read', 'patient_analytics');
        return view('analytics.patients');
    }

    public function doctors(): View
    {
        $this->auditLogger->log('read', 'doctor_analytics');
        return view('analytics.doctors');
    }

    public function departments(): View
    {
        $this->auditLogger->log('read', 'department_analytics');
        return view('analytics.departments');
    }

    public function pharmacy(): View
    {
        $this->auditLogger->log('read', 'pharmacy_analytics');
        return view('analytics.pharmacy');
    }

    public function laboratory(): View
    {
        $this->auditLogger->log('read', 'laboratory_analytics');
        return view('analytics.laboratory');
    }

    public function inventory(): View
    {
        $this->auditLogger->log('read', 'inventory_analytics');
        return view('analytics.inventory');
    }

    public function hr(): View
    {
        $this->auditLogger->log('read', 'hr_analytics');
        return view('analytics.hr');
    }

    public function appointments(): View
    {
        $this->auditLogger->log('read', 'appointment_analytics');
        return view('analytics.appointments');
    }

    public function finance(): View
    {
        $this->auditLogger->log('read', 'finance_analytics');
        return view('analytics.finance');
    }

    public function forecast(Request $request): View
    {
        $type = $request->input('type') ?? 'revenue';
        $forecast = $this->forecastService->predict($type);
        
        $this->auditLogger->log('read', 'forecasting_model_' . $type);
        return view('analytics.forecast', compact('forecast', 'type'));
    }

    public function audit(Request $request): View
    {
        $module = $request->input('module');
        $action = $request->input('action');
        
        $query = AuditEvent::with('user');
        
        if ($module) {
            $query->where('affected_module', $module);
        }
        if ($action) {
            $query->where('action', $action);
        }

        $events = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $this->auditLogger->log('read', 'security_audit_logs');
        return view('analytics.audit', compact('events', 'module', 'action'));
    }

    public function reports(): View
    {
        $schedules = ScheduledReport::all();
        $this->auditLogger->log('read', 'scheduled_reports');
        return view('analytics.reports', compact('schedules'));
    }

    public function settings(): View
    {
        $widgets = DashboardWidget::where('user_id', Auth::id())->get();
        return view('analytics.settings', compact('widgets'));
    }

    public function updateWidgets(Request $request): JsonResponse
    {
        $widgetCoords = $request->input('widgets') ?? [];
        foreach ($widgetCoords as $w) {
            DashboardWidget::where('user_id', Auth::id())
                ->where('widget_key', $w['key'])
                ->update([
                    'x_pos' => $w['x'],
                    'y_pos' => $w['y'],
                    'is_active' => $w['active'] ?? true,
                ]);
        }

        $this->auditLogger->log('update', 'dashboard_layout');
        return response()->json(['success' => true]);
    }

    public function saveFilter(Request $request): JsonResponse
    {
        $filter = SavedFilter::create([
            'user_id' => Auth::id(),
            'filter_name' => $request->input('name'),
            'module' => $request->input('module'),
            'filter_json' => $request->input('filters'),
        ]);

        return response()->json(['success' => true, 'filter' => $filter]);
    }

    public function scheduleReport(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'report_type' => 'required|string',
            'frequency' => 'required|string',
            'recipient_email' => 'required|email',
        ]);

        ScheduledReport::create([
            'name' => $request->input('name'),
            'report_type' => $request->input('report_type'),
            'frequency' => $request->input('frequency'),
            'recipient_email' => $request->input('recipient_email'),
        ]);

        $this->auditLogger->log('create', 'scheduled_report');
        return redirect()->back()->with('success', 'Report schedule registered successfully.');
    }
}
