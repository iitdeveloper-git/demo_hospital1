@extends('layouts.patient', ['title' => 'My Patient Profile'])

@section('content')
<div class="profile-container-inner">
    <div class="profile-layout-grid">
        <!-- Left: Card Overview -->
        <div class="profile-sidebar-card">
            <div class="avatar-large">
                @if(Auth::user()->avatar_url)
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                @else
                    <span>{{ substr(Auth::user()->name, 0, 2) }}</span>
                @endif
            </div>
            <h2>{{ Auth::user()->name }}</h2>
            <span class="patient-id-badge"><i class="fa-solid fa-id-card"></i> {{ $patient->patient_code }}</span>
            
            <div class="sidebar-meta-list">
                <div class="meta-item-side">
                    <span class="label">Primary Email</span>
                    <span class="val">{{ Auth::user()->email }}</span>
                </div>
                <div class="meta-item-side">
                    <span class="label">Contact Phone</span>
                    <span class="val">{{ Auth::user()->phone }}</span>
                </div>
            </div>
        </div>

        <!-- Right: Detail Tabs -->
        <div class="profile-details-panel">
            <!-- Medical Card -->
            <div class="details-section">
                <h3><i class="fa-solid fa-notes-medical"></i> Demographics & Health Profile</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <span class="label">Date of Birth</span>
                        <span class="value">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Years old)</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Gender</span>
                        <span class="value">{{ ucfirst($patient->gender) }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Blood Group</span>
                        <span class="value highlight-blood">{{ $patient->blood_group ?? 'Not Specified' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Emergency Contact</span>
                        <span class="value">{{ $patient->emergency_contact }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Insurance Provider</span>
                        <span class="value">{{ $patient->insurance_provider ?? 'No insurance on file' }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Account Status</span>
                        <span class="value"><span class="pill-active">Active Profile</span></span>
                    </div>
                </div>
            </div>

            <!-- Medical Alerts -->
            <div class="details-section">
                <h3><i class="fa-solid fa-triangle-exclamation"></i> Critical Medical Alerts</h3>
                <div class="alerts-container">
                    @if(!empty($patient->medical_alerts))
                        @foreach($patient->medical_alerts as $alert)
                            <div class="medical-alert-tag">
                                <i class="fa-solid fa-circle-exclamation"></i>
                                <span>{{ $alert }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="no-alerts-card">
                            <i class="fa-solid fa-circle-check"></i>
                            <p>No active allergies or medical alerts flagged on your record.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-layout-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .profile-sidebar-card {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 32px 24px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 20px;
        background-color: var(--brand-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: 2px solid var(--border-color);
    }

    .avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-large span {
        font-size: 32px;
        font-weight: 700;
        color: var(--brand-primary);
    }

    .profile-sidebar-card h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        margin: 0 0 8px;
    }

    .patient-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 600;
        margin-bottom: 24px;
    }

    .sidebar-meta-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        text-align: left;
        border-top: 1px solid var(--border-color);
        padding-top: 20px;
    }

    .meta-item-side {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .meta-item-side .label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
    }

    .meta-item-side .val {
        font-size: 14px;
        font-weight: 500;
        word-break: break-all;
    }

    /* Details styling */
    .profile-details-panel {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .details-section {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 28px;
    }

    .details-section h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        margin: 0 0 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 16px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .detail-item .label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .detail-item .value {
        font-size: 15px;
        font-weight: 600;
    }

    .highlight-blood {
        color: #ef4444;
        font-weight: 700 !important;
    }

    .pill-active {
        background-color: rgba(16, 185, 129, 0.08);
        color: #10b981;
        padding: 4px 10px;
        border-radius: 99px;
        font-size: 12px;
        font-weight: 600;
    }

    /* Alerts styling */
    .alerts-container {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .medical-alert-tag {
        background-color: rgba(239, 68, 68, 0.08);
        border: 1px solid rgba(239, 68, 68, 0.15);
        color: #ef4444;
        padding: 8px 16px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .no-alerts-card {
        display: flex;
        align-items: center;
        gap: 10px;
        background-color: rgba(16, 185, 129, 0.08);
        color: #10b981;
        padding: 12px 20px;
        border-radius: 8px;
        width: 100%;
    }

    .no-alerts-card p {
        margin: 0;
        font-size: 13px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-layout-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
