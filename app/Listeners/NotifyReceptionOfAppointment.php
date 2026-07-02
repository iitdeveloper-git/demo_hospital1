<?php

namespace App\Listeners;

use App\Events\AppointmentRequested;
use Illuminate\Support\Facades\Log;

class NotifyReceptionOfAppointment
{
    public function handle(AppointmentRequested $event): void
    {
        Log::info('Appointment request routed to reception queue.', $event->appointment);
    }
}
