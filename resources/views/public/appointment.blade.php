@extends('layouts.public')

@section('content')
<div class="appointment-page">
    <!-- Hero Banner Section -->
    <section class="appointment-hero">
        <div class="appointment-hero__content">
            <nav class="appointment-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">Book Appointment</span>
            </nav>
            <h1>Enterprise Online Booking</h1>
            <p class="subtitle">Select your clinical department, preferred specialist, and schedule your priority care slot instantly.</p>
        </div>
    </section>

    <!-- Main Booking Section -->
    <section class="section booking-section">
        <div class="booking-grid">
            <!-- Form Card -->
            <div class="booking-card" data-aos="fade-right">
                <div class="booking-card__header">
                    <h2>Schedule Consultation</h2>
                    <p>Please fill out the form below. Our reception desk will verify your details and send a confirmation email.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('appointments.store') }}" method="POST" class="booking-form">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required maxlength="120" autocomplete="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="john@example.com" required autocomplete="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+91 98765 43210" required autocomplete="tel">
                        </div>
                        <div class="form-group">
                            <label for="appointment_at">Preferred Date & Time <span class="required">*</span></label>
                            <input type="datetime-local" id="appointment_at" name="appointment_at" value="{{ old('appointment_at') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="department_id">Clinical Department <span class="required">*</span></label>
                            <select id="department_id" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id', request('department')) == $dept->id || old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="doctor_id">Preferred Specialist <span class="optional">(Optional)</span></label>
                            <select id="doctor_id" name="doctor_id">
                                <option value="">Select Specialist (Any)</option>
                                @foreach($doctors as $doc)
                                    <option value="{{ $doc->id }}" data-department="{{ $doc->department_id }}" {{ old('doctor_id', request('doctor')) == $doc->id || old('doctor_id') == $doc->id ? 'selected' : '' }}>
                                        {{ $doc->full_name }} ({{ $doc->specialization }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label for="reason">Reason for Visit <span class="required">*</span></label>
                        <textarea id="reason" name="reason" rows="4" placeholder="Briefly describe your symptoms or medical requirements..." required maxlength="1000">{{ old('reason') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary submit-btn">
                        <i class="fa-solid fa-calendar-check"></i> Request Appointment
                    </button>
                </form>
            </div>

            <!-- Information Panel -->
            <div class="info-sidebar" data-aos="fade-left">
                <div class="info-card">
                    <h3><i class="fa-solid fa-shield-halved"></i> Secure Patient Workflows</h3>
                    <p>All appointment requests are processed securely in compliance with healthcare data protection standards.</p>
                </div>

                <div class="info-card">
                    <h3><i class="fa-solid fa-clock"></i> Response SLA</h3>
                    <p>Our triage and coordination desks confirm all booking slots within <strong>15 minutes</strong> of online submission.</p>
                </div>

                <div class="info-card helpline-card">
                    <h3>Need Emergency Assistance?</h3>
                    <p>If you require immediate medical care or emergency ambulance transport, call our 24/7 hotline directly.</p>
                    <a href="tel:+911800123456" class="helpline-number">
                        <i class="fa-solid fa-phone-volume"></i> +91 1800 123 456
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Custom Styled Appointment System */
.appointment-page {
    background: var(--canvas, #f8fafc);
}

.appointment-hero {
    position: relative;
    padding: 60px 24px;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #ffffff;
    text-align: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.appointment-hero__content {
    max-width: 800px;
    margin: 0 auto;
}

.appointment-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(8px);
    padding: 6px 16px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 16px;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.appointment-breadcrumbs a {
    color: #94a3b8;
    text-decoration: none;
    transition: color 0.2s;
}

.appointment-breadcrumbs a:hover {
    color: #ffffff;
}

.appointment-breadcrumbs .separator {
    color: #475569;
    font-size: 10px;
}

.appointment-breadcrumbs .current {
    color: #38bdf8;
}

.appointment-hero h1 {
    font-size: clamp(28px, 4vw, 42px);
    margin: 0 0 12px;
    font-weight: 800;
    letter-spacing: -0.02em;
}

.appointment-hero .subtitle {
    font-size: clamp(14px, 1.8vw, 17px);
    color: #94a3b8;
    margin: 0;
    line-height: 1.5;
}

.booking-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 48px 24px;
}

.booking-grid {
    display: grid;
    grid-template-columns: 1.4fr 0.8fr;
    gap: 32px;
    align-items: start;
}

.booking-card {
    background: var(--white, #ffffff);
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.025);
}

.booking-card__header {
    margin-bottom: 24px;
    border-bottom: 1px solid var(--line, #e2e8f0);
    padding-bottom: 16px;
}

.booking-card__header h2 {
    font-size: 22px;
    margin: 0 0 8px;
    color: #0f172a;
}

.booking-card__header p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.5;
}

.alert-danger {
    background: #fef2f2;
    border: 1px solid #fee2e2;
    color: #991b1b;
    padding: 16px;
    border-radius: 8px;
    margin-bottom: 24px;
    font-size: 14px;
}

.alert-danger ul {
    list-style: none;
    padding-left: 0;
    margin: 0;
}

.alert-danger li {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.alert-danger li:last-child {
    margin-bottom: 0;
}

.booking-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
}

.form-group label .required {
    color: #ef4444;
}

.form-group label .optional {
    color: #94a3b8;
    font-weight: 400;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 10px 14px;
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    background: #ffffff;
    color: #0f172a;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

.submit-btn {
    align-self: flex-start;
    padding: 12px 24px;
    font-size: 15px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
}

/* Sidebar Info Panel */
.info-sidebar {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.info-card {
    background: var(--white, #ffffff);
    border: 1px solid var(--line, #e2e8f0);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
}

.info-card h3 {
    font-size: 15px;
    margin: 0 0 8px;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #0f172a;
}

.info-card h3 i {
    color: #3b82f6;
}

.info-card p {
    margin: 0;
    font-size: 13px;
    color: #64748b;
    line-height: 1.5;
}

.helpline-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
    color: #ffffff;
    border: none;
}

.helpline-card h3 {
    color: #ffffff;
}

.helpline-card p {
    color: #93c5fd;
    margin-bottom: 16px;
}

.helpline-number {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 700;
    color: #60a5fa;
    text-decoration: none;
    transition: color 0.2s;
}

.helpline-number:hover {
    color: #ffffff;
}

@media (max-width: 768px) {
    .booking-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const departmentSelect = document.getElementById('department_id');
    const doctorSelect = document.getElementById('doctor_id');
    const doctorOptions = Array.from(doctorSelect.options);

    function filterDoctors() {
        const selectedDeptId = departmentSelect.value;
        
        // Clear doctor select and add default option
        doctorSelect.innerHTML = '';
        
        const defaultOption = doctorOptions[0];
        doctorSelect.appendChild(defaultOption);
        
        const filtered = doctorOptions.filter(option => {
            if (!option.value) return false;
            const docDeptId = option.getAttribute('data-department');
            return !selectedDeptId || docDeptId === selectedDeptId;
        });
        
        filtered.forEach(option => {
            doctorSelect.appendChild(option);
        });
    }

    departmentSelect.addEventListener('change', filterDoctors);

    // Initial run to apply filter if department is preselected
    if (departmentSelect.value) {
        filterDoctors();
    }
});
</script>
@endsection
