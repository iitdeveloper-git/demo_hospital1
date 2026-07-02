@extends('layouts.reception', ['title' => 'Instant Walk-in Booking'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h2>Book Walk-in Outpatient Appointment</h2>
    </div>
    
    <form action="{{ route('reception.walk-in') }}" method="POST" class="walk-in-form">
        @csrf
        
        <div class="form-group">
            <label for="patient_id">Patient</label>
            <select id="patient_id" name="patient_id" required>
                <option value="">Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="department_id">Clinical Department</label>
            <select id="department_id" name="department_id" required>
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="doctor_id">Consulting Specialist</label>
            <select id="doctor_id" name="doctor_id" required>
                <option value="">Select Specialist</option>
                @foreach($doctors as $doc)
                    <option value="{{ $doc->id }}">{{ $doc->full_name }} ({{ $doc->specialization }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="time_slot">Preferred Time Slot</label>
            <select id="time_slot" name="time_slot" required>
                <option value="09:00:00">09:00 AM</option>
                <option value="10:00:00">10:00 AM</option>
                <option value="11:00:00">11:00 AM</option>
                <option value="12:00:00">12:00 PM</option>
                <option value="14:00:00">02:00 PM</option>
                <option value="15:00:00">03:00 PM</option>
                <option value="16:00:00">04:00 PM</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top:10px;"><i class="fa-solid fa-calendar-plus"></i> Allocate Queue Token</button>
    </form>
</div>

<style>
    .walk-in-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .walk-in-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .walk-in-form label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .walk-in-form select {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
    }

    .walk-in-form select:focus {
        outline: none;
        border-color: var(--brand-primary);
    }
</style>
@endsection
