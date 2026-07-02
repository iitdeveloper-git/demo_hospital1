@extends('layouts.doctor', ['title' => 'Clinical Profile'])

@section('content')
<div class="doctor-profile-wrap">
    <div class="profile-grid">
        <!-- Sidebar Info -->
        <div class="panel sidebar-profile-card">
            <div class="avatar-wrap-large">
                @if($doctor->photo)
                    <img src="{{ $doctor->photo }}" alt="{{ $doctor->full_name }}">
                @else
                    <span>{{ substr($doctor->full_name, 4, 2) }}</span>
                @endif
            </div>
            <h2>{{ $doctor->full_name }}</h2>
            <span class="specialty-text">{{ $doctor->specialization }}</span>
            <span class="employee-id"><i class="fa-solid fa-id-badge"></i> {{ $doctor->employee_id }}</span>

            <div class="sidebar-meta-list">
                <div class="meta-row">
                    <span class="label">Consultation Fee</span>
                    <strong>${{ number_format($doctor->consultation_fee, 2) }}</strong>
                </div>
                <div class="meta-row">
                    <span class="label">Online Session Fee</span>
                    <strong>${{ number_format($doctor->online_fee, 2) }}</strong>
                </div>
                <div class="meta-row">
                    <span class="label">Hospital</span>
                    <span>{{ $doctor->hospital }}</span>
                </div>
            </div>
        </div>

        <!-- Details Area -->
        <div class="details-area">
            <!-- Professional Summary -->
            <div class="panel">
                <h3><i class="fa-solid fa-user-md"></i> Professional Summary</h3>
                <p class="profile-bio">{{ $doctor->bio ?? 'Dedicated senior clinical specialist committed to delivering exceptional patient care pathways.' }}</p>
                
                <div class="info-blocks-grid">
                    <div class="info-block">
                        <span class="label">Qualification</span>
                        <strong>{{ $doctor->qualification }}</strong>
                    </div>
                    <div class="info-block">
                        <span class="label">Experience</span>
                        <strong>{{ $doctor->experience_years }} Years</strong>
                    </div>
                    <div class="info-block">
                        <span class="label">Registration</span>
                        <strong>{{ $doctor->registration_number }}</strong>
                    </div>
                    <div class="info-block">
                        <span class="label">Languages</span>
                        <strong>{{ implode(', ', $doctor->languages ?? ['English']) }}</strong>
                    </div>
                </div>
            </div>

            <!-- Certificates, Awards, Publications -->
            <div class="panel">
                <h3><i class="fa-solid fa-award"></i> Credentials & Publications</h3>
                <div class="list-section">
                    <h4>Expertise Area</h4>
                    <div class="tag-group">
                        @foreach($doctor->expertise ?? ['General Medicine'] as $exp)
                            <span class="badge badge-primary">{{ $exp }}</span>
                        @endforeach
                    </div>
                </div>
                
                <div class="list-section">
                    <h4>Publications</h4>
                    <ul class="publications-list">
                        @foreach($doctor->publications ?? ['No publications loaded'] as $pub)
                            <li><i class="fa-solid fa-book-open"></i> {{ $pub }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-grid {
        display: grid;
        grid-template-columns: 0.8fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .sidebar-profile-card {
        text-align: center;
        padding: 32px 24px !important;
    }

    .avatar-wrap-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 16px;
        background-color: var(--brand-soft);
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-size: 32px;
        font-weight: 700;
        border: 2px solid var(--border-color);
    }

    .avatar-wrap-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-profile-card h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        margin: 0 0 4px;
    }

    .specialty-text {
        font-size: 13px;
        color: var(--text-muted);
        display: block;
        margin-bottom: 8px;
    }

    .employee-id {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 12px;
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

    .meta-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }

    .meta-row .label {
        color: var(--text-muted);
    }

    /* Details styling */
    .details-area {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .details-area h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .profile-bio {
        font-size: 14px;
        line-height: 1.6;
        color: var(--text-main);
        margin: 0 0 24px;
    }

    .info-blocks-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .info-block {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-block .label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
    }

    .info-block strong {
        font-size: 14px;
    }

    .list-section {
        margin-bottom: 20px;
    }

    .list-section:last-child {
        margin-bottom: 0;
    }

    .list-section h4 {
        font-size: 14px;
        margin: 0 0 10px;
    }

    .tag-group {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .tag-group .badge {
        background-color: var(--brand-soft);
        color: var(--brand-primary);
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 4px;
    }

    .publications-list {
        list-style: none;
        padding-left: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13.5px;
    }

    .publications-list li {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .publications-list i {
        color: var(--brand-primary);
    }

    @media (max-width: 768px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
