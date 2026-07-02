<?php

namespace App\Services\Analytics;

class ForecastService
{
    /**
     * Compute future estimations based on historical trend parameters.
     */
    public function predict(string $type, int $monthsAhead = 6): array
    {
        $baseline = $this->getBaseline($type);
        $growth = $this->getGrowthRate($type);
        
        $predictions = [];
        $labels = [];
        
        for ($i = 1; $i <= $monthsAhead; $i++) {
            $factor = 1 + ($growth * $i) + ($this->getSeasonalFactor($type, $i));
            $predictions[] = round($baseline * $factor, 2);
            $labels[] = now()->addMonths($i)->format('M Y');
        }

        return [
            'labels' => $labels,
            'values' => $predictions,
            'growth_estimate' => ($growth * 100) . '%',
        ];
    }

    private function getBaseline(string $type): float
    {
        switch ($type) {
            case 'revenue': return 540000.00;
            case 'patient': return 1200;
            case 'bed_demand': return 42;
            case 'medicine_demand': return 850;
            default: return 100.00;
        }
    }

    private function getGrowthRate(string $type): float
    {
        switch ($type) {
            case 'revenue': return 0.04; // 4% monthly
            case 'patient': return 0.02;
            case 'bed_demand': return 0.01;
            case 'medicine_demand': return 0.03;
            default: return 0.01;
        }
    }

    private function getSeasonalFactor(string $type, int $monthOffset): float
    {
        // Simple sin wave simulator for seasonal influenza/weather shifts
        return sin($monthOffset) * 0.05;
    }
}
