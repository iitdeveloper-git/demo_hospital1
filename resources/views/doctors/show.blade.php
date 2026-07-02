@extends('layouts.public')

@section('content')
<div class="doctor-profile-page">
    <!-- Cover & Profile Hero Header -->
    <section class="doc-profile-hero" style="background-image: linear-gradient(rgba(11, 36, 84, 0.82), rgba(11, 36, 84, 0.95)), url('{{ asset('public/images/hospital.png') }}');">
        <div class="doc-profile-hero-container">
            <div class="doc-profile-avatar-wrap">
                <img src="{{ asset($doctor->photo ?? 'public/images/dr_aanya_sharma.png') }}" alt="{{ $doctor->full_name }}">
            </div>
            <div class="doc-profile-hero-info">
                <nav class="about-breadcrumbs" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                    <a href="{{ route('doctors.index') }}">Doctors</a>
                    <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                    <span class="current">{{ $doctor->full_name }}</span>
                </nav>
                <span class="doc-dept-badge"><i class="fa-solid {{ $doctor->department->icon ?? 'fa-stethoscope' }}"></i> {{ $doctor->department->name }}</span>
                <h1>{{ $doctor->full_name }}</h1>
                <p class="subtitle">{{ $doctor->qualification }} - {{ $doctor->specialization }}</p>
                <div class="doc-hero-stats">
                    <span><i class="fa-solid fa-briefcase"></i> <strong>{{ $doctor->experience_years }}+ Years</strong> Experience</span>
                    <span><i class="fa-solid fa-star"></i> <strong>{{ $doctor->rating }}</strong> ({{ $doctor->review_count }} Reviews)</span>
                    <span><i class="fa-solid fa-user-check"></i> <strong>{{ $doctor->patients_treated }}+</strong> Patients Treated</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Grid Content -->
    <section class="section doc-profile-body">
        <div class="doc-profile-layout-grid">
            <!-- Main Content Area -->
            <div class="doc-profile-main">
                <!-- Biography -->
                <article class="profile-card" id="bio" data-aos="fade-up">
                    <h2>Biography</h2>
                    <p class="rich-text">{{ $doctor->bio }}</p>
                </article>

                <!-- Education & Work Experience -->
                <article class="profile-card" id="education" data-aos="fade-up">
                    <h2>Education & Credentials</h2>
                    <div class="timeline-wrap">
                        <div class="timeline-item">
                            <div class="item-icon"><i class="fa-solid fa-graduation-cap"></i></div>
                            <div class="item-content">
                                <h3>Medical Education</h3>
                                <p>{{ $doctor->education }}</p>
                            </div>
                        </div>
                        @if($doctor->certifications)
                            <div class="timeline-item">
                                <div class="item-icon"><i class="fa-solid fa-certificate"></i></div>
                                <div class="item-content">
                                    <h3>Board Certifications</h3>
                                    <ul class="cert-list">
                                        @foreach($doctor->certifications as $cert)
                                            <li>{{ $cert }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <!-- Schedule Calendar -->
                <article class="profile-card" id="schedule" data-aos="fade-up">
                    <h2>Weekly Availability Schedule</h2>
                    <div class="schedule-calendar-grid">
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            @php
                                $shortDay = substr($day, 0, 3);
                                $isAvailable = $doctor->working_days && in_array($shortDay, $doctor->working_days);
                            @endphp
                            <div class="calendar-day-box {{ $isAvailable ? 'available' : 'holiday' }}">
                                <h4>{{ $day }}</h4>
                                @if($isAvailable)
                                    <span class="time-slot">{{ $doctor->working_hours }}</span>
                                    <span class="status-available">Available</span>
                                @else
                                    <span class="time-slot">-</span>
                                    <span class="status-holiday">Off Duty</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </article>

                <!-- Patient Reviews -->
                <article class="profile-card" id="reviews" data-aos="fade-up">
                    <h2>Patient Testimonials & Reviews</h2>
                    <div class="reviews-list-container">
                        @forelse($doctor->reviews as $review)
                            <div class="patient-review-card">
                                <div class="reviewer-meta">
                                    <div class="reviewer-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="reviewer-info">
                                        <h3>{{ $review->patient_name }}</h3>
                                        <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
                                        @if($review->is_verified)
                                            <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Patient</span>
                                        @endif
                                    </div>
                                    <div class="reviewer-stars">
                                        @foreach(range(1, $review->rating) as $star)
                                            <i class="fa-solid fa-star text-warning"></i>
                                        @endforeach
                                    </div>
                                </div>
                                <p class="review-text">"{{ $review->review }}"</p>
                            </div>
                        @empty
                            <p class="no-reviews">No patient reviews have been posted yet.</p>
                        @endforelse
                    </div>
                </article>
            </div>

            <!-- Sidebar Area -->
            <aside class="doc-profile-sidebar">
                <div class="sticky-sidebar-container">
                    <!-- Consultation Booking Widget -->
                    <div class="sidebar-widget booking-widget">
                        <h3>Book Consultation</h3>
                        <div class="price-box">
                            <span class="label">In-Clinic OPD Fee</span>
                            <span class="price-val">₹{{ number_format($doctor->consultation_fee, 0) }}</span>
                        </div>
                        @if($doctor->video_consultation)
                            <div class="price-box border-top">
                                <span class="label">Online Video Fee</span>
                                <span class="price-val">₹{{ number_format($doctor->online_fee, 0) }}</span>
                            </div>
                        @endif
                        <a href="{{ route('public.page', ['page' => 'appointment']) }}?doctor={{ urlencode($doctor->full_name) }}&department={{ urlencode($doctor->department->name) }}&fee={{ $doctor->consultation_fee }}" class="btn btn-primary full-width-btn">Book In-Person Appointment</a>
                        @if($doctor->video_consultation)
                            <a href="{{ route('public.page', ['page' => 'appointment']) }}?doctor={{ urlencode($doctor->full_name) }}&department={{ urlencode($doctor->department->name) }}&type=video&fee={{ $doctor->online_fee }}" class="btn btn-soft full-width-btn">Book Video Consultation</a>
                        @endif
                    </div>

                    <!-- Contact details -->
                    <div class="sidebar-widget contact-widget">
                        <h3>AarogyaCare Assistance</h3>
                        <p>Outer Ring Road, near HealthTech Park, Bengaluru, Karnataka 560103</p>
                        <a href="tel:+911800123456" class="phone-link"><i class="fa-solid fa-phone"></i> +91 1800 123 456</a>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</div>

<style>
/* Premium Styles for Doctor Profile */
.doc-profile-hero {
    padding: 64px clamp(18px, 5vw, 72px);
    color: #fff;
}

.doc-profile-hero-container {
    display: flex;
    gap: 32px;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.doc-profile-avatar-wrap {
    width: 200px;
    height: 200px;
    border-radius: 16px;
    overflow: hidden;
    border: 4px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
}

.doc-profile-avatar-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.doc-profile-hero-info h1 {
    font-size: clamp(28px, 5vw, 42px);
    margin: 8px 0;
}

.doc-profile-hero-info .subtitle {
    font-size: 18px;
    color: #bfdbfe;
    margin: 0 0 16px;
}

.doc-hero-stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    font-size: 14px;
    color: #dbeafe;
}

.doc-hero-stats strong {
    color: #fff;
}

.doc-profile-layout-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 36px;
    align-items: start;
}

.profile-card {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 32px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.profile-card h2 {
    margin: 0 0 20px;
    color: var(--blue-900);
    font-size: 22px;
    border-left: 4px solid var(--blue-600);
    padding-left: 12px;
}

.rich-text {
    font-size: 16px;
    line-height: 1.8;
    color: var(--muted);
}

/* Timeline Credentials */
.timeline-wrap {
    display: grid;
    gap: 24px;
}

.timeline-item {
    display: flex;
    gap: 16px;
}

.item-icon {
    font-size: 24px;
    color: var(--blue-600);
    flex-shrink: 0;
}

.item-content h3 {
    margin: 0 0 8px;
    font-size: 16px;
    color: var(--blue-900);
}

.cert-list {
    padding-left: 20px;
    margin: 0;
    color: var(--muted);
}

/* Weekly calendar */
.schedule-calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
}

.calendar-day-box {
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 12px;
    text-align: center;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.calendar-day-box h4 {
    margin: 0;
    font-size: 13px;
    color: var(--blue-900);
}

.calendar-day-box .time-slot {
    font-size: 11px;
    color: var(--muted);
}

.calendar-day-box.available {
    background: var(--soft);
}

.calendar-day-box.holiday {
    background: var(--canvas);
    opacity: 0.7;
}

.status-available {
    font-size: 11px;
    color: var(--success);
    font-weight: 700;
}

.status-holiday {
    font-size: 11px;
    color: var(--muted);
}

/* Reviews */
.patient-review-card {
    border-bottom: 1px solid var(--line);
    padding: 20px 0;
}

.patient-review-card:last-of-type {
    border-bottom: 0;
    padding-bottom: 0;
}

.reviewer-meta {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.reviewer-avatar {
    width: 44px;
    height: 44px;
    background: var(--soft);
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: var(--blue-600);
}

.reviewer-info h3 {
    margin: 0;
    font-size: 15px;
    color: var(--blue-900);
}

.review-date {
    font-size: 12px;
    color: var(--muted);
}

.verified-badge {
    font-size: 11px;
    color: var(--success);
    font-weight: 700;
    margin-left: 8px;
}

.reviewer-stars {
    margin-left: auto;
}

.text-warning {
    color: var(--warning);
}

.review-text {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.6;
    margin: 0;
}

/* Sidebar Widgets */
.doc-profile-sidebar {
    position: sticky;
    top: 92px;
}

.sidebar-widget {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: var(--shadow);
}

.sidebar-widget h3 {
    margin: 0 0 16px;
    font-size: 18px;
    color: var(--blue-900);
}

.price-box {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
    padding-bottom: 12px;
}

.price-box.border-top {
    border-top: 1px solid var(--line);
    padding-top: 12px;
}

.price-box .label {
    font-size: 13px;
    color: var(--muted);
}

.price-box .price-val {
    font-size: 28px;
    font-weight: 800;
    color: var(--blue-700);
}

.phone-link {
    font-size: 18px;
    font-weight: 700;
    color: var(--blue-600);
    text-decoration: none;
}

@media (max-width: 980px) {
    .doc-profile-hero-container {
        flex-direction: column;
        text-align: center;
    }
    .doc-hero-stats {
        justify-content: center;
    }
    .doc-profile-layout-grid {
        grid-template-columns: 1fr;
    }
    .schedule-calendar-grid {
        grid-template-columns: repeat(4, 1fr);
    }
}

@media (max-width: 640px) {
    .schedule-calendar-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>
@endsection
