<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KpiTarget;
use App\Models\DashboardWidget;
use App\Models\AnalyticsSnapshot;
use App\Models\AuditEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalyticsModuleSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        // 1. Seed 1000 KPI targets
        $kpisData = [];
        $kpiNames = [
            ['Revenue target', 'financial', 500000.00, 480000.00],
            ['Patient Satisfaction Rating', 'clinical', 95.00, 92.00],
            ['Average waiting duration', 'operational', 15.00, 18.00],
            ['OT Bed utilisation percentage', 'operational', 85.00, 80.00],
            ['Medicine Inventory Accuracy', 'clinical', 99.00, 96.00],
            ['Cardiology OPD referrals', 'clinical', 120.00, 130.00],
        ];

        for ($i = 1; $i <= 1000; $i++) {
            $k = $kpiNames[$i % count($kpiNames)];
            $target = $k[2] + rand(-20, 20);
            $curr = $k[3] + rand(-30, 20);
            $pct = round(($curr / max(1.0, $target)) * 100, 2);

            $kpisData[] = [
                'kpi_name' => $k[0] . " (Zone #$i)",
                'target_value' => $target,
                'current_value' => $curr,
                'achievement_percentage' => $pct,
                'category' => $k[1],
                'starts_at' => now()->startOfMonth()->toDateString(),
                'ends_at' => now()->endOfMonth()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($kpisData, 200) as $chunk) {
            DB::table('kpi_targets')->insert($chunk);
        }

        // 2. Seed material snapshots representing 5 years (monthly logs for performance)
        $snapshots = [];
        $now = now();
        for ($i = 0; $i < 60; $i++) {
            $date = $now->copy()->subMonths($i)->toDateString();
            $snapshots[] = [
                'branch_id' => 1,
                'snapshot_date' => $date,
                'category' => 'revenue',
                'metrics_json' => json_encode([
                    'total_revenue' => rand(150000, 950000),
                    'opd_count' => rand(100, 1200),
                    'ipd_count' => rand(20, 300),
                    'expenses' => rand(80000, 40000),
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('analytics_snapshots')->insert($snapshots);

        // 3. Seed Default Widgets
        $widgets = [
            'revenue_card', 'patient_growth', 'waiting_time_gauge', 'ot_utilization', 'lab_vs_pharmacy_revenue'
        ];
        foreach ($widgets as $idx => $wKey) {
            DashboardWidget::create([
                'user_id' => $users->first()->id,
                'widget_key' => $wKey,
                'width' => 4,
                'height' => 3,
                'x_pos' => ($idx % 3) * 4,
                'y_pos' => floor($idx / 3) * 3,
                'is_active' => true,
            ]);
        }

        // 4. Seed Audit Events
        $actions = ['login', 'logout', 'create', 'update', 'delete', 'finance'];
        $modules = ['patients', 'doctors', 'billing', 'prescriptions', 'inventory', 'lims', 'settings'];
        $audits = [];
        for ($i = 1; $i <= 50; $i++) {
            $audits[] = [
                'session_id' => Str::random(16),
                'user_id' => $users->random()->id,
                'action' => $actions[$i % count($actions)],
                'affected_module' => $modules[$i % count($modules)],
                'ip_address' => '192.168.1.' . rand(1, 254),
                'browser' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'old_values_json' => json_encode(['status' => 'pending']),
                'new_values_json' => json_encode(['status' => 'approved']),
                'created_at' => now()->subMinutes($i * 12),
            ];
        }
        DB::table('audit_events')->insert($audits);
    }
}
