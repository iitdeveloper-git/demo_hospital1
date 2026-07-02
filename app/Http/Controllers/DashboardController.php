<?php

namespace App\Http\Controllers;

use App\Services\DashboardMetricService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly DashboardMetricService $metrics)
    {
    }

    public function show(string $role): View
    {
        abort_unless(in_array($role, array_keys(config('AarogyaCare.roles')), true), 404);

        return view('dashboard.index', [
            'role' => $role,
            'roleName' => config("AarogyaCare.roles.$role.name"),
            'metrics' => $this->metrics->snapshot($role),
            'nav' => config("AarogyaCare.roles.$role.nav"),
        ]);
    }
}
