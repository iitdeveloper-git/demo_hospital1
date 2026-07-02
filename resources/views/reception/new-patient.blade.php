@extends('layouts.reception', ['title' => 'Patient Onboarding Form'])

@section('content')
<div class="panel" style="max-width: 700px; margin: 0 auto;">
    <div class="panel-header">
        <h2>Register New Outpatient</h2>
    </div>
    
    <form action="{{ route('reception.new-patient') }}" method="POST" class="patient-reg-form">
        @csrf
        
        <div class="form-row">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <select id="blood_group" name="blood_group">
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact Mobile</label>
                <input type="tel" id="emergency_contact" name="emergency_contact" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 10px;"><i class="fa-solid fa-user-plus"></i> Complete Patient Registration</button>
    </form>
</div>

<style>
    .patient-reg-form {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .patient-reg-form .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .patient-reg-form label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .patient-reg-form input,
    .patient-reg-form select {
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background-color: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
        font-size: 13.5px;
    }

    .patient-reg-form input:focus,
    .patient-reg-form select:focus {
        outline: none;
        border-color: var(--brand-primary);
    }
</style>
@endsection
