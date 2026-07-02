<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:160'],
            'phone' => ['required', 'string', 'max:30'],
            'department_id' => ['required', 'integer', 'exists:departments,id'],
            'doctor_id' => ['nullable', 'integer', 'exists:doctors,id'],
            'appointment_at' => ['required', 'date', 'after:now'],
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }
}
