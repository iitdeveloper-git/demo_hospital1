@extends('layouts.public')

@section('content')
<div class="service-detail-page">
    <!-- Hero Banner -->
    <section class="page-banner service-detail-hero" style="background-image: linear-gradient(rgba(11, 36, 84, 0.88), rgba(11, 36, 84, 0.95)), url('{{ asset('public/images/hospital.png') }}');">
        <div class="banner-content">
            <nav class="about-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <a href="{{ route('services.index') }}">Services</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">{{ $service->title }}</span>
            </nav>
            <span class="eyebrow-badge"><i class="fa-solid {{ $service->icon }}"></i> {{ $service->department->name }}</span>
            <h1>{{ $service->title }}</h1>
            <p>{{ $service->short_description }}</p>
        </div>
    </section>

    <!-- Content Layout Grid -->
    <section class="section service-detail-layout">
        <div class="detail-grid-container">
            <!-- Main Content Area -->
            <div class="detail-main-content">
                <!-- Overview -->
                <article class="detail-section-card" id="overview" data-aos="fade-up">
                    <h2>Service Overview</h2>
                    <div class="rich-text-content">
                        <p>{{ $service->full_description }}</p>
                    </div>
                </article>

                <!-- Benefits -->
                @if($service->benefits)
                    <article class="detail-section-card" id="benefits" data-aos="fade-up">
                        <h2>Key Benefits & Outcomes</h2>
                        <ul class="benefits-tick-list">
                            @foreach($service->benefits as $benefit)
                                <li><i class="fa-solid fa-circle-check"></i> <span>{{ $benefit }}</span></li>
                            @endforeach
                        </ul>
                    </article>
                @endif

                <!-- Procedure Timeline -->
                @if($service->procedure)
                    <article class="detail-section-card" id="procedure" data-aos="fade-up">
                        <h2>The Treatment Procedure</h2>
                        <div class="timeline-steps">
                            @foreach($service->procedure as $index => $step)
                                <div class="timeline-step-item">
                                    <div class="step-badge">Step {{ $index + 1 }}</div>
                                    <p>{{ $step }}</p>
                                </div>
                            @endforeach
                        </div>
                    </article>
                @endif

                <!-- Preparation Guidelines -->
                @if($service->preparation)
                    <article class="detail-section-card" id="preparation" data-aos="fade-up">
                        <h2>How to Prepare</h2>
                        <ul class="prep-bullet-list">
                            @foreach($service->preparation as $prep)
                                <li><i class="fa-solid fa-circle-info"></i> <span>{{ $prep }}</span></li>
                            @endforeach
                        </ul>
                    </article>
                @endif

                <!-- Recovery instructions -->
                @if($service->recovery_time)
                    <article class="detail-section-card" id="recovery" data-aos="fade-up">
                        <h2>Post-Procedure Recovery</h2>
                        <div class="recovery-box">
                            <i class="fa-solid fa-clock-rotate-left recovery-icon"></i>
                            <div>
                                <h3>Estimated Recovery Time: <strong>{{ $service->recovery_time }}</strong></h3>
                                <p>Our recovery coordinators will provide you with a detailed recovery log, follow-up appointment timeline, and direct line contact for any questions during your healing phase.</p>
                            </div>
                        </div>
                    </article>
                @endif

                <!-- Related Doctors Showcase -->
                <article class="detail-section-card" id="doctors" data-aos="fade-up">
                    <h2>Related Specialty Clinicians</h2>
                    <div class="doctors-showcase-grid">
                        @forelse($relatedDoctors as $doctor)
                            <div class="doctor-detail-mini-card">
                                <img src="{{ asset($doctor->user->avatar_url ?? 'public/images/dr_aanya_sharma.png') }}" alt="{{ $doctor->user->name }}">
                                <div class="doc-info-wrap">
                                    <h3>{{ $doctor->user->name }}</h3>
                                    <span class="doc-qualification">{{ $doctor->qualification ?? $doctor->specialization }}</span>
                                    <span class="doc-exp"><i class="fa-solid fa-briefcase"></i> {{ $doctor->experience_years }} Years Exp</span>
                                    <span class="doc-rating"><i class="fa-solid fa-star"></i> {{ $doctor->rating }}</span>
                                    <div class="doc-status">
                                        <span class="status-dot"></span> Available Today
                                    </div>
                                    <a href="{{ route('public.page', ['page' => 'appointment']) }}?service={{ urlencode($service->title) }}&department={{ urlencode($service->department->name) }}&doctor={{ urlencode($doctor->user->name) }}" class="btn btn-primary btn-sm">Book Appt</a>
                                </div>
                            </div>
                        @empty
                            <p class="no-doctors-text">Our reception desk will map the best available clinician for your appointment.</p>
                        @endforelse
                    </div>
                </article>

                <!-- FAQs -->
                @if($service->faq)
                    <article class="detail-section-card" id="faq" data-aos="fade-up">
                        <h2>Frequently Asked Questions</h2>
                        <div class="faq-accordion-wrapper">
                            @foreach($service->faq as $faq)
                                <details class="faq-accordion-item">
                                    <summary>{{ $faq['question'] }}</summary>
                                    <p>{{ $faq['answer'] }}</p>
                                </details>
                            @endforeach
                        </div>
                    </article>
                @endif
            </div>

            <!-- Sticky Sidebar Area -->
            <aside class="detail-sidebar">
                <div class="sticky-sidebar-container">
                    <!-- Service Pricing Card -->
                    <div class="sidebar-widget pricing-widget">
                        <h3>Estimated Pricing</h3>
                        <div class="price-box">
                            <span class="label">Starting from</span>
                            <span class="price-val">₹{{ number_format($service->price_from, 0) }}</span>
                        </div>
                        <div class="service-dur-box">
                            <span><i class="fa-solid fa-hourglass-half"></i> Duration: <strong>{{ $service->duration }}</strong></span>
                        </div>
                        <a href="{{ route('public.page', ['page' => 'appointment']) }}?service={{ urlencode($service->title) }}&department={{ urlencode($service->department->name) }}" class="btn btn-primary full-width-btn">Book Appointment</a>
                    </div>

                    <!-- Emergency Assistance Card -->
                    <div class="sidebar-widget emergency-widget">
                        <h3><i class="fa-solid fa-phone-volume"></i> 24x7 Assistance</h3>
                        <p>Need urgent advice or ambulance dispatch? Contact our emergency response desks immediately.</p>
                        <a href="tel:+911800123456" class="emergency-phone">+91 1800 123 456</a>
                    </div>

                    <!-- Download Brochure Widget -->
                    <div class="sidebar-widget download-widget">
                        <h3>Brochure Downloads</h3>
                        <p>Get a comprehensive PDF guide covering preparation, treatment, and recovery instructions.</p>
                        <button class="btn btn-soft full-width-btn"><i class="fa-solid fa-file-pdf"></i> Download Brochure</button>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- Related Services Slider -->
    @if($relatedServices->count() > 0)
        <section class="section related-services-section">
            <div class="section-heading section-heading--center">
                <span class="eyebrow">More Options</span>
                <h2>Related Treatment Services</h2>
            </div>
            <div class="related-services-grid">
                @foreach($relatedServices as $relService)
                    <article class="service-card-premium hover-lift">
                        <div class="card-image-wrap">
                            <img src="{{ asset($relService->featured_image) }}" alt="{{ $relService->title }}">
                            <span class="card-dept-badge"><i class="fa-solid {{ $relService->icon }}"></i> {{ $relService->department->name }}</span>
                        </div>
                        <div class="card-content-wrap">
                            <h3>{{ $relService->title }}</h3>
                            <p class="card-desc">{{ $relService->short_description }}</p>
                            <div class="card-footer-actions">
                                <a href="{{ route('services.show', $relService->slug) }}" class="btn btn-soft full-width-btn">View Details</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>

<style>
/* Premium CSS styles for Service Detail page */
.service-detail-hero {
    height: 40vh;
    min-height: 320px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

.eyebrow-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(20, 184, 166, 0.2);
    border: 1px solid var(--teal);
    color: var(--teal);
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 12px;
}

.service-detail-hero h1 {
    font-size: clamp(30px, 5vw, 52px);
    margin: 0 0 12px;
}

.service-detail-layout {
    background: var(--canvas);
}

.detail-grid-container {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 36px;
    align-items: start;
}

.detail-section-card {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 32px;
    margin-bottom: 24px;
    box-shadow: var(--shadow);
}

.detail-section-card h2 {
    margin: 0 0 20px;
    color: var(--blue-900);
    font-size: 24px;
    border-left: 4px solid var(--blue-600);
    padding-left: 12px;
}

.rich-text-content p {
    font-size: 16px;
    line-height: 1.8;
    color: var(--muted);
}

.benefits-tick-list, .prep-bullet-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    gap: 16px;
}

.benefits-tick-list li, .prep-bullet-list li {
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.benefits-tick-list i {
    color: var(--success);
    font-size: 20px;
    margin-top: 2px;
}

.prep-bullet-list i {
    color: var(--warning);
    font-size: 20px;
    margin-top: 2px;
}

.benefits-tick-list span, .prep-bullet-list span {
    font-size: 16px;
    color: var(--muted);
}

/* Timeline steps */
.timeline-steps {
    display: grid;
    gap: 24px;
    border-left: 2px solid var(--line);
    padding-left: 20px;
    margin-left: 12px;
}

.timeline-step-item {
    position: relative;
}

.step-badge {
    position: absolute;
    left: -48px;
    top: 0;
    background: var(--blue-600);
    color: #fff;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}

.timeline-step-item p {
    font-size: 16px;
    color: var(--muted);
    margin: 0;
    line-height: 1.6;
}

/* Recovery box */
.recovery-box {
    display: flex;
    gap: 20px;
    background: var(--soft);
    border: 1px solid var(--line);
    padding: 24px;
    border-radius: 8px;
}

.recovery-icon {
    font-size: 32px;
    color: var(--blue-600);
}

.recovery-box h3 {
    margin: 0 0 8px;
    font-size: 18px;
    color: var(--blue-900);
}

.recovery-box p {
    margin: 0;
    font-size: 14px;
    line-height: 1.6;
    color: var(--muted);
}

/* Related Doctors Mini Card */
.doctors-showcase-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.doctor-detail-mini-card {
    display: flex;
    gap: 16px;
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 16px;
    background: var(--canvas);
}

.doctor-detail-mini-card img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 6px;
}

.doc-info-wrap h3 {
    margin: 0 0 4px;
    font-size: 16px;
    color: var(--blue-900);
}

.doc-qualification {
    display: block;
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 6px;
}

.doc-exp, .doc-rating {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--muted);
    margin-right: 12px;
}

.doc-rating i {
    color: var(--warning);
}

.doc-status {
    margin: 8px 0;
    font-size: 12px;
    color: var(--success);
    font-weight: 700;
}

.doc-status .status-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: var(--success);
    border-radius: 50%;
    margin-right: 4px;
}

/* FAQ Accordion */
.faq-accordion-wrapper {
    display: grid;
    gap: 12px;
}

.faq-accordion-item {
    border: 1px solid var(--line);
    border-radius: 8px;
}

.faq-accordion-item summary {
    padding: 16px;
    font-weight: 700;
    cursor: pointer;
}

.faq-accordion-item p {
    padding: 0 16px 16px;
    margin: 0;
    color: var(--muted);
    font-size: 14px;
    line-height: 1.6;
}

/* Sidebar Widgets */
.detail-sidebar {
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

.pricing-widget h3 {
    border-bottom: 1px solid var(--line);
    padding-bottom: 12px;
}

.price-box {
    display: flex;
    flex-direction: column;
    margin-bottom: 16px;
}

.price-box .label {
    font-size: 13px;
    color: var(--muted);
}

.price-box .price-val {
    font-size: 32px;
    font-weight: 800;
    color: var(--blue-700);
}

.service-dur-box {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 20px;
}

.full-width-btn {
    width: 100%;
}

.emergency-widget {
    background: linear-gradient(135deg, #0f6fff, #0b2454);
    color: #fff;
}

.emergency-widget h3, .emergency-widget p {
    color: #fff;
}

.emergency-phone {
    display: block;
    margin-top: 12px;
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    text-decoration: none;
}

/* Related services slider */
.related-services-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-top: 24px;
}

@media (max-width: 980px) {
    .detail-grid-container {
        grid-template-columns: 1fr;
    }
    .related-services-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .doctors-showcase-grid, .related-services-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
