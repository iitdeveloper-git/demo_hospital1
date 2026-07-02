<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient' => $this->patient?->user?->name,
            'doctor' => $this->doctor?->user?->name,
            'department' => $this->department?->name,
            'appointment_at' => $this->appointment_at?->toIso8601String(),
            'type' => $this->type,
            'status' => $this->status,
            'triage_score' => $this->triage_score,
        ];
    }
}
