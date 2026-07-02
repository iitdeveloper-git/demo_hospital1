<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor')?->id;

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:doctors,email,' . $doctorId],
            'employee_id' => ['required', 'string', 'unique:doctors,employee_id,' . $doctorId],
            'doctor_code' => ['required', 'string', 'unique:doctors,doctor_code,' . $doctorId],
            'department_id' => ['required', 'exists:departments,id'],
            'specialization' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:255'],
            'registration_number' => ['required', 'string', 'unique:doctors,registration_number,' . $doctorId],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'online_fee' => ['required', 'numeric', 'min:0'],
            'languages' => ['nullable', 'array'],
            'expertise' => ['nullable', 'array'],
            'awards' => ['nullable', 'array'],
            'certifications' => ['nullable', 'array'],
            'working_days' => ['nullable', 'array'],
            'working_hours' => ['required', 'string'],
            'status' => ['required', 'string', 'in:active,inactive'],
        ];
    }
}
