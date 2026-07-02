@extends('layouts.public')

@section('content')
<!-- Schema.org Organization Markup -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MedicalOrganization",
  "name": "AarogyaCare",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/hospital.png') }}",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+91-1800-123-456",
    "contactType": "emergency",
    "areaServed": "IN",
    "availableLanguage": ["en", "hi"]
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Outer Ring Road, near HealthTech Park",
    "addressLocality": "Bengaluru",
    "addressRegion": "Karnataka",
    "postalCode": "560103",
    "addressCountry": "IN"
  }
}
</script>

<div class="about-page">
    <!-- Hero Banner Section -->
    <section class="about-hero" style="background-image: linear-gradient(rgba(11, 36, 84, 0.85), rgba(11, 36, 84, 0.95)), url('{{ asset('public/images/hospital.png') }}');">
        <!-- Floating Particles -->
        <div class="about-hero__particles">
            <span class="particle particle--1"></span>
            <span class="particle particle--2"></span>
            <span class="particle particle--3"></span>
            <span class="particle particle--4"></span>
            <span class="particle particle--5"></span>
            <span class="particle particle--6"></span>
        </div>

        <div class="about-hero__content">
            <!-- Breadcrumbs -->
            <nav class="about-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">About Us</span>
            </nav>

            <h1>About AarogyaCare</h1>
            <p class="subtitle">Committed to Compassion, Innovation and Excellence in Healthcare</p>
        </div>

        <!-- Scroll Indicator -->
        <a href="#our-story" class="about-scroll-indicator" aria-label="Scroll to content">
            <span class="mouse">
                <span class="wheel"></span>
            </span>
        </a>
    </section>

    <!-- Content Sections for Trust, Professionalism & Authenticity -->
    <section id="our-story" class="section about-story">
        <div class="about-story__grid">
            <div class="about-story__content" data-aos="fade-right">
                <span class="eyebrow">Our Legacy</span>
                <h2>Pioneering Advanced Medical Care in India</h2>
                <p>Founded on the principles of empathy, innovation, and clinical excellence, AarogyaCare has evolved into one of the country's premier multi-specialty healthcare institutions. We combine top-tier clinical talents with state-of-the-art AI triage technologies to deliver precision treatments and seamless patient pathways.</p>
                <div class="about-stats">
                    <div class="about-stat-card">
                        <strong>15+</strong>
                        <span>Specialty Units</span>
                    </div>
                    <div class="about-stat-card">
                        <strong>99.4%</strong>
                        <span>Care Satisfaction</span>
                    </div>
                </div>
            </div>
            <div class="about-story__image" data-aos="fade-left">
                <div class="about-image-wrapper">
                    <img src="{{ asset('public/images/hospital.png') }}" alt="AarogyaCare Building">
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Premium About Page Custom Styles */
.about-hero {
    position: relative;
    height: 60vh;
    min-height: 480px;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 0 24px;
    color: #ffffff;
    overflow: hidden;
}

.about-hero__particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
}

.particle {
    position: absolute;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 50%;
    animation: floatParticle 8s infinite ease-in-out;
}

.particle--1 { width: 12px; height: 12px; left: 10%; top: 20%; animation-delay: 0s; }
.particle--2 { width: 24px; height: 24px; left: 25%; top: 60%; animation-delay: 2s; }
.particle--3 { width: 8px; height: 8px; left: 45%; top: 15%; animation-delay: 4s; }
.particle--4 { width: 16px; height: 16px; left: 60%; top: 75%; animation-delay: 1s; }
.particle--5 { width: 20px; height: 20px; left: 80%; top: 30%; animation-delay: 3s; }
.particle--6 { width: 10px; height: 10px; left: 90%; top: 70%; animation-delay: 5s; }

@keyframes floatParticle {
    0%, 100% { transform: translateY(0) scale(1); opacity: 0.3; }
    50% { transform: translateY(-40px) scale(1.1); opacity: 0.8; }
}

.about-hero__content {
    position: relative;
    z-index: 2;
    max-width: 800px;
}

.about-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    padding: 8px 18px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 24px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.about-breadcrumbs a {
    color: #bfdbfe;
    transition: color 0.2s;
}

.about-breadcrumbs a:hover {
    color: #ffffff;
}

.about-breadcrumbs .separator {
    color: rgba(255, 255, 255, 0.4);
    font-size: 10px;
}

.about-hero h1 {
    font-size: clamp(38px, 6vw, 64px);
    margin: 0 0 16px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.02em;
}

.about-hero .subtitle {
    font-size: clamp(16px, 2.5vw, 22px);
    color: #bfdbfe;
    margin: 0;
    font-weight: 500;
    line-height: 1.4;
}

/* Scroll Indicator */
.about-scroll-indicator {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    cursor: pointer;
}

.about-scroll-indicator .mouse {
    width: 26px;
    height: 42px;
    border: 2px solid rgba(255, 255, 255, 0.4);
    border-radius: 15px;
    display: block;
    position: relative;
}

.about-scroll-indicator .wheel {
    width: 4px;
    height: 8px;
    background: #ffffff;
    border-radius: 2px;
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    animation: scrollWheel 1.5s infinite;
}

@keyframes scrollWheel {
    0% { top: 8px; opacity: 1; }
    100% { top: 18px; opacity: 0; }
}

/* Story Section */
.about-story {
    background: var(--canvas);
}

.about-story__grid {
    display: grid;
    grid-template-columns: 1.1fr 0.9fr;
    gap: 48px;
    align-items: center;
}

.about-story__content h2 {
    font-size: clamp(26px, 4vw, 42px);
    margin: 12px 0 20px;
    line-height: 1.15;
}

.about-story__content p {
    font-size: 16px;
    line-height: 1.8;
    color: var(--muted);
    margin-bottom: 32px;
}

.about-stats {
    display: flex;
    gap: 24px;
}

.about-stat-card {
    background: var(--white);
    border: 1px solid var(--line);
    padding: 20px 32px;
    border-radius: 12px;
    box-shadow: var(--shadow);
    flex: 1;
}

.about-stat-card strong {
    display: block;
    font-size: 36px;
    color: var(--blue-700);
    margin-bottom: 4px;
}

.about-stat-card span {
    color: var(--muted);
    font-size: 14px;
    font-weight: 600;
}

.about-image-wrapper {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.about-image-wrapper img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

@media (max-width: 768px) {
    .about-story__grid {
        grid-template-columns: 1fr;
        gap: 36px;
    }
}
</style>
@endsection
