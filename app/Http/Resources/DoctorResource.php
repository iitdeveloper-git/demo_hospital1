<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'doctor_code' => $this->doctor_code,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'slug' => $this->slug,
            'specialization' => $this->specialization,
            'qualification' => $this->qualification,
            'experience_years' => $this->experience_years,
            'consultation_fee' => $this->consultation_fee,
            'online_fee' => $this->online_fee,
            'rating' => $this->rating,
            'review_count' => $this->review_count,
            'available_today' => $this->available_today,
            'video_consultation' => $this->video_consultation,
            'status' => $this->status,
            'department' => [
                'id' => $this->department_id,
                'name' => $this->department?->name,
                'slug' => $this->department?->slug,
            ],
        ];
    }
}
