<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Http\RedirectResponse;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request): RedirectResponse
    {
        $request->session()->flash('toast', [
            'type' => 'success',
            'message' => 'Appointment request received. Our reception team will confirm shortly.',
        ]);

        return back();
    }
}
