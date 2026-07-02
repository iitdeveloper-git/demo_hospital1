@extends('layouts.public')

@php
    $quickServices = [
        ['icon' => 'fa-calendar-check', 'title' => 'Book Appointment', 'description' => 'Priority OPD and specialist slots', 'href' => route('public.page', 'appointment')],
        ['icon' => 'fa-truck-medical', 'title' => 'Emergency', 'description' => '24x7 ambulance and trauma desk', 'href' => 'tel:+911800123456'],
        ['icon' => 'fa-user-doctor', 'title' => 'Find Doctor', 'description' => 'Match with verified specialists', 'href' => route('public.page', 'doctors')],
        ['icon' => 'fa-hospital', 'title' => 'Departments', 'description' => 'Explore specialty care units', 'href' => route('public.page', 'departments')],
        ['icon' => 'fa-vial-circle-check', 'title' => 'Lab Test', 'description' => 'Book diagnostics with reports', 'href' => route('public.page', 'services')],
        ['icon' => 'fa-notes-medical', 'title' => 'Health Packages', 'description' => 'Preventive plans for every age', 'href' => route('public.page', 'health-packages')],
        ['icon' => 'fa-video', 'title' => 'Online Consultation', 'description' => 'Secure virtual care visits', 'href' => route('dashboard.role', 'patient')],
        ['icon' => 'fa-file-medical', 'title' => 'Medical Records', 'description' => 'Digital EMR and lab history', 'href' => route('dashboard.role', 'patient')],
    ];

    $departmentCards = [
        ['name' => 'Cardiology', 'icon' => 'fa-heart-pulse', 'image' => 'https://images.unsplash.com/photo-1628348068343-c6a848d2b6dd?auto=format&fit=crop&w=900&q=82', 'description' => 'Heart care, cath lab coordination, cardiac risk scoring, and recovery plans.'],
        ['name' => 'Neurology', 'icon' => 'fa-brain', 'image' => 'https://images.unsplash.com/photo-1559757175-5700dde675bc?auto=format&fit=crop&w=900&q=82', 'description' => 'Stroke response, neuro diagnostics, memory care, and rehabilitation pathways.'],
        ['name' => 'Orthopedic', 'icon' => 'fa-bone', 'image' => 'https://images.unsplash.com/photo-1579154204601-01588f351e67?auto=format&fit=crop&w=900&q=82', 'description' => 'Joint replacement, sports injury, spine care, and physiotherapy support.'],
        ['name' => 'Dental', 'icon' => 'fa-tooth', 'image' => 'https://images.unsplash.com/photo-1606811971618-4486d14f3f99?auto=format&fit=crop&w=900&q=82', 'description' => 'Cosmetic dentistry, oral surgery, implants, and preventive dental care.'],
        ['name' => 'ENT', 'icon' => 'fa-ear-listen', 'image' => 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=900&q=82', 'description' => 'Hearing, sinus, voice, sleep, and minimally invasive ENT procedures.'],
        ['name' => 'Radiology', 'icon' => 'fa-x-ray', 'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=900&q=82', 'description' => 'MRI, CT, ultrasound, digital X-ray, and AI-supported imaging reports.'],
        ['name' => 'ICU', 'icon' => 'fa-bed-pulse', 'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=900&q=82', 'description' => 'Critical care monitoring, ventilator support, infection control, and specialist rounds.'],
        ['name' => 'Emergency', 'icon' => 'fa-kit-medical', 'image' => 'https://images.unsplash.com/photo-1587745416684-47953f16f02f?auto=format&fit=crop&w=900&q=82', 'description' => '24x7 trauma, ambulance coordination, fast triage, and emergency diagnostics.'],
    ];

    $doctorCards = [
        ['name' => 'Dr. Aanya Sharma', 'role' => 'Senior Cardiologist', 'qualification' => 'MD, DM Cardiology', 'experience' => '18 Years', 'rating' => '4.9', 'image' => '/images/dr_aanya_sharma.png'],
        ['name' => 'Dr. Rohan Mehta', 'role' => 'Neurosurgeon', 'qualification' => 'MS, MCh Neuro', 'experience' => '16 Years', 'rating' => '4.8', 'image' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Nisha Iyer', 'role' => 'Pediatrician', 'qualification' => 'MD Pediatrics', 'experience' => '12 Years', 'rating' => '4.9', 'image' => 'https://images.unsplash.com/photo-1594824476967-48c8b964273f?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Kabir Sethi', 'role' => 'Orthopedic Surgeon', 'qualification' => 'MS Ortho', 'experience' => '14 Years', 'rating' => '4.7', 'image' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Meera Kapoor', 'role' => 'Radiologist', 'qualification' => 'MD Radiodiagnosis', 'experience' => '11 Years', 'rating' => '4.8', 'image' => 'https://images.unsplash.com/photo-1651008376811-b90baee60c1f?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Arjun Nair', 'role' => 'Emergency Physician', 'qualification' => 'MD Emergency Medicine', 'experience' => '13 Years', 'rating' => '4.9', 'image' => 'https://images.unsplash.com/photo-1607990281513-2c110a25bd8c?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Sara Khan', 'role' => 'ENT Consultant', 'qualification' => 'MS ENT', 'experience' => '10 Years', 'rating' => '4.8', 'image' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Dev Patel', 'role' => 'Critical Care Lead', 'qualification' => 'MD, IDCCM', 'experience' => '15 Years', 'rating' => '4.9', 'image' => 'https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=700&q=82'],
        ['name' => 'Dr. Sushma Sharma', 'role' => 'Pediatrician', 'qualification' => 'MD Pediatrics', 'experience' => '10 Years', 'rating' => '4.8', 'image' => '/images/dr_sushma_sharma.png'],
    ];

    $packages = [
        ['name' => 'Silver Package', 'price' => '$49', 'features' => ['CBC and ESR', 'Liver profile', 'Doctor review', 'Digital report']],
        ['name' => 'Gold Package', 'price' => '$89', 'features' => ['Silver benefits', 'Cardiac markers', 'Thyroid profile', 'Diet consultation']],
        ['name' => 'Premium Package', 'price' => '$149', 'features' => ['Gold benefits', 'CT risk scan', 'Specialist consult', 'Priority lounge']],
        ['name' => 'Family Package', 'price' => '$249', 'features' => ['Four member screening', 'Pediatric review', 'Dental check', 'Care coordinator']],
        ['name' => 'Corporate Package', 'price' => '$399', 'features' => ['Employee wellness', 'Occupational health', 'Analytics report', 'HR dashboard']],
    ];

    $testimonials = [
        ['name' => 'Priya Menon', 'visited' => 'Cardiology', 'review' => 'The cardiology team explained every step clearly and the discharge summary was available on my phone before I left.', 'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Ravi Kumar', 'visited' => 'Emergency', 'review' => 'Ambulance coordination was fast, triage was calm, and my family received real-time updates throughout treatment.', 'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Sneha Rao', 'visited' => 'Maternity', 'review' => 'Our care coordinator made every appointment, lab test, and insurance approval feel effortless.', 'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Amit Shah', 'visited' => 'Orthopedic', 'review' => 'Excellent surgical planning, transparent billing, and physiotherapy follow-up after knee replacement.', 'image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Fatima Ali', 'visited' => 'Radiology', 'review' => 'MRI scheduling was quick and the digital report reached my doctor without any chasing.', 'image' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'George Mathew', 'visited' => 'ICU', 'review' => 'The ICU team was highly professional and gave us structured family briefings twice a day.', 'image' => 'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Kavya Nair', 'visited' => 'Pediatrics', 'review' => 'The pediatric department was warm, organized, and very careful with our child’s records.', 'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Harish Bhat', 'visited' => 'Neurology', 'review' => 'The stroke follow-up program helped us manage medicines, therapy, and progress reviews in one place.', 'image' => 'https://images.unsplash.com/photo-1507591064344-4c6ce005b128?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Neha Gill', 'visited' => 'Dental', 'review' => 'Clean clinic, painless procedure, and clear estimate before the treatment started.', 'image' => 'https://images.unsplash.com/photo-1548142813-c348350df52b?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Imran Sheikh', 'visited' => 'ENT', 'review' => 'Booking, consultation, procedure, and post-care instructions were all handled beautifully.', 'image' => 'https://images.unsplash.com/photo-1547425260-76bcadfb4f2c?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Lina Dsouza', 'visited' => 'Diagnostics', 'review' => 'Home sample collection was punctual and reports were easy to understand.', 'image' => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=300&q=82'],
        ['name' => 'Manoj Verma', 'visited' => 'Oncology', 'review' => 'The oncology board gave us a clear treatment pathway and helped with insurance documentation.', 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=82'],
    ];

    $blogs = [
        ['title' => 'How AI Triage Helps Emergency Teams Move Faster', 'category' => 'Emergency', 'author' => 'AarogyaCare Desk', 'date' => 'Jul 01, 2026', 'image' => 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?auto=format&fit=crop&w=900&q=82'],
        ['title' => 'Five Preventive Tests Every Family Should Schedule', 'category' => 'Wellness', 'author' => 'Dr. Nisha Iyer', 'date' => 'Jun 28, 2026', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=82'],
        ['title' => 'Digital Health Records: What Patients Should Know', 'category' => 'Patient Care', 'author' => 'Care Team', 'date' => 'Jun 24, 2026', 'image' => 'https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=900&q=82'],
        ['title' => 'Recovering Stronger After Joint Replacement', 'category' => 'Orthopedic', 'author' => 'Dr. Kabir Sethi', 'date' => 'Jun 18, 2026', 'image' => 'https://images.unsplash.com/photo-1579684453377-48ec05c6b30a?auto=format&fit=crop&w=900&q=82'],
        ['title' => 'What Makes a Modern ICU Safer for Families', 'category' => 'Critical Care', 'author' => 'ICU Team', 'date' => 'Jun 12, 2026', 'image' => 'https://images.unsplash.com/photo-1512678080530-7760d81faba6?auto=format&fit=crop&w=900&q=82'],
        ['title' => 'Understanding Cardiac Risk Before Symptoms Start', 'category' => 'Cardiology', 'author' => 'Dr. Aanya Sharma', 'date' => 'Jun 05, 2026', 'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=900&q=82'],
    ];

    $faqs = [
        'How do I book an appointment at AarogyaCare?' => 'Use the appointment form, call our care desk, or sign in to the patient portal for real-time doctor slots.',
        'Is emergency care available 24x7?' => 'Yes, emergency, ambulance, ICU escalation, and trauma response remain active around the clock.',
        'Can I consult doctors online?' => 'Yes, secure video consultations are available for selected specialties and follow-up visits.',
        'How quickly are lab reports delivered?' => 'Most routine reports are published digitally the same day, with critical values escalated immediately.',
        'Do you support insurance approvals?' => 'Our billing desk coordinates cashless and reimbursement documentation with major insurers.',
        'Can I access my medical records online?' => 'Patients can view prescriptions, lab reports, bills, appointments, and discharge summaries in the portal.',
        'Are health packages customizable?' => 'Yes, preventive health packages can be tailored by age, risk profile, company, and family size.',
        'What should I bring for my first visit?' => 'Please bring ID, previous prescriptions, reports, insurance card, and current medication details.',
        'Do you have specialist doctors every day?' => 'Core specialties run daily OPD schedules, while super-specialist slots are published in advance.',
        'Is the hospital accessible for wheelchair users?' => 'Yes, AarogyaCare includes wheelchair access, priority lifts, assisted parking, and accessible washrooms.',
        'Can family members receive updates?' => 'With patient consent, care coordinators share structured updates through phone and portal notifications.',
        'How do I request ambulance support?' => 'Call the emergency number in the top bar for immediate ambulance dispatch and ER preparation.',
        'Are payments available online?' => 'Bills, package bookings, deposits, and insurance balances can be handled through digital payment workflows.',
        'Can I choose a preferred doctor?' => 'Yes, you can search by specialty, doctor, experience, rating, and available time slot.',
        'How secure is patient data?' => 'The platform is designed around role permissions, encrypted sessions, validation, audit-ready access, and secure records.',
    ];
@endphp

@section('content')
<section class="home-hero" id="home">
    <div class="hero-bg-shape hero-bg-shape--one"></div>
    <div class="hero-bg-shape hero-bg-shape--two"></div>
    <div class="home-hero__copy" data-aos="fade-right">
        <span class="hero-badge"><i class="fa-solid fa-shield-heart"></i> Trusted by modern care teams</span>
        <h1>Advanced Healthcare For Your Family</h1>
        <p>Experience premium, connected hospital care with AI-assisted triage, expert doctors, digital records, diagnostics, pharmacy, insurance, and emergency support in one elegant ecosystem.</p>
        <div class="hero-actions">
            <x-site.button :href="route('public.page', 'appointment')" icon="fa-calendar-check">Book Appointment</x-site.button>
            <x-site.button :href="route('public.page', 'doctors')" variant="soft" icon="fa-user-doctor">Find Doctor</x-site.button>
        </div>
        <div class="hero-trust" aria-label="Trust indicators">
            <span><strong>24x7</strong> Emergency</span>
            <span><strong>100+</strong> Doctors</span>
            <span><strong>50,000+</strong> Happy Patients</span>
        </div>
    </div>
        <div class="home-hero__visual" data-aos="fade-left">
        <div class="image-orbit">
            <img loading="eager" src="/images/hospital.png" alt="AarogyaCare Building">
            <div class="hero-float-card float-card--top"><i class="fa-solid fa-user-doctor"></i><strong>100+</strong><span>Expert Doctors</span></div>
            <div class="hero-float-card float-card--bottom"><i class="fa-solid fa-heart-pulse"></i><strong>98%</strong><span>Satisfaction</span></div>
            <i class="medical-float medical-float--ambulance fa-solid fa-truck-medical"></i>
            <i class="medical-float medical-float--heart fa-solid fa-heart-pulse"></i>
            <i class="medical-float medical-float--cross fa-solid fa-square-plus"></i>
        </div>
    </div>
    <a class="scroll-indicator" href="#quick-services" aria-label="Scroll to services"><span></span></a>
</section>

<section class="section quick-services" id="quick-services">
    <x-site.section-title eyebrow="Quick Access" title="Care services one tap away" description="Fast actions for patients, families, doctors, and hospital coordinators." align="center" />
    <div class="quick-service-grid">
        @foreach($quickServices as $service)
            <x-site.icon-card :icon="$service['icon']" :title="$service['title']" :description="$service['description']" :href="$service['href']" data-aos="fade-up" />
        @endforeach
    </div>
</section>

<section class="stats-band" data-counter-section>
    @foreach([['100+', 'Doctors'], ['10000+', 'Patients'], ['25+', 'Departments'], ['50000+', 'Appointments'], ['98%', 'Patient Satisfaction']] as $stat)
        <div class="stat-item">
            <strong data-counter="{{ preg_replace('/\D/', '', $stat[0]) }}" data-suffix="{{ str_contains($stat[0], '%') ? '%' : '+' }}">0</strong>
            <span>{{ $stat[1] }}</span>
        </div>
    @endforeach
</section>

<section class="section about-preview">
    <div class="about-image-stack" data-aos="fade-right">
        <img loading="lazy" src="https://images.unsplash.com/photo-1504439468489-c8920d796a29?auto=format&fit=crop&w=1100&q=84" alt="Hospital leadership team">
        <div class="ceo-card">
            <strong>Dr. Kavita Rao</strong>
            <span>Chief Executive Officer</span>
            <p>Care should feel precise, personal, and reassuring at every step.</p>
        </div>
    </div>
    <div data-aos="fade-left">
        <x-site.section-title eyebrow="About AarogyaCare" title="Clinical excellence with a deeply human touch" description="AarogyaCare brings specialists, diagnostics, pharmacy, billing, insurance, and digital patient engagement into a calm premium experience." />
        <div class="mission-grid">
            <article><i class="fa-solid fa-bullseye"></i><h3>Mission</h3><p>Deliver safe, transparent, digitally connected healthcare for every family we serve.</p></article>
            <article><i class="fa-solid fa-eye"></i><h3>Vision</h3><p>Become the most trusted smart hospital platform for modern medical institutions.</p></article>
        </div>
        <x-site.button :href="route('public.page', 'about')" variant="soft" icon="fa-arrow-right">Read More</x-site.button>
    </div>
</section>

<section class="section departments-showcase" id="departments">
    <x-site.section-title eyebrow="Departments" title="Specialty care departments" description="Integrated departments designed for faster diagnosis, better coordination, and measurable outcomes." align="center" />
    <div class="department-grid">
        @foreach($departmentCards as $department)
            <article class="department-card hover-lift" data-aos="zoom-in">
                <img loading="lazy" src="{{ $department['image'] }}" alt="{{ $department['name'] }} department">
                <span><i class="fa-solid {{ $department['icon'] }}"></i></span>
                <h3>{{ $department['name'] }}</h3>
                <p>{{ $department['description'] }}</p>
                <a href="{{ route('public.page', 'departments') }}">Explore <i class="fa-solid fa-arrow-right"></i></a>
            </article>
        @endforeach
    </div>
</section>

<section class="section doctors-showcase">
    <x-site.section-title eyebrow="Featured Doctors" title="Meet trusted medical specialists" description="Experienced clinicians supported by digital workflows, diagnostics, and care coordinators." align="center" />
    <div class="doctor-grid">
        @foreach($doctorCards as $doctor)
            <article class="doctor-card hover-lift" data-aos="fade-up">
                <img loading="lazy" src="{{ $doctor['image'] }}" alt="{{ $doctor['name'] }}">
                <div>
                    <span>{{ $doctor['experience'] }}</span>
                    <span><i class="fa-solid fa-star"></i> {{ $doctor['rating'] }}</span>
                </div>
                <h3>{{ $doctor['name'] }}</h3>
                <p>{{ $doctor['role'] }} - {{ $doctor['qualification'] }}</p>
                <div class="card-actions">
                    <a class="btn btn-primary ripple" href="{{ route('public.page', 'appointment') }}">Book</a>
                    <a class="btn btn-soft ripple" href="{{ route('public.page', 'doctors') }}">Profile</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section why-choose">
    <x-site.section-title eyebrow="Why Choose Us" title="Hospital care designed around trust" align="center" />
    <div class="why-grid">
        @foreach([['fa-user-doctor','Experienced Doctors'], ['fa-microscope','Modern Equipment'], ['fa-truck-medical','Emergency Care'], ['fa-file-shield','Digital Records'], ['fa-hand-holding-dollar','Affordable Treatment'], ['fa-shield-heart','Insurance Support']] as $item)
            <article class="why-card hover-lift" data-aos="fade-up"><i class="fa-solid {{ $item[0] }}"></i><h3>{{ $item[1] }}</h3><p>Built for dependable care, transparent workflows, and a calm patient experience.</p></article>
        @endforeach
    </div>
</section>

<section class="section package-section" id="health-packages">
    <x-site.section-title eyebrow="Health Packages" title="Preventive care plans" description="Flexible wellness packages for individuals, families, and corporate teams." align="center" />
    <div class="package-grid">
        @foreach($packages as $package)
            <article class="package-card hover-lift">
                <h3>{{ $package['name'] }}</h3>
                <strong>{{ $package['price'] }}</strong>
                <ul>
                    @foreach($package['features'] as $feature)
                        <li><i class="fa-solid fa-check"></i>{{ $feature }}</li>
                    @endforeach
                </ul>
                <a class="btn btn-primary ripple" href="{{ route('public.page', 'appointment') }}">Book Now</a>
            </article>
        @endforeach
    </div>
</section>

<section class="appointment-cta">
    <div>
        <span class="eyebrow">Need care today?</span>
        <h2>Book a specialist appointment or call emergency support.</h2>
        <div class="hero-actions">
            <x-site.button :href="route('public.page', 'appointment')" icon="fa-calendar-check">Book Appointment</x-site.button>
            <x-site.button href="tel:+911800123456" variant="soft" icon="fa-phone">Emergency Call</x-site.button>
        </div>
    </div>
    <img loading="lazy" src="https://images.unsplash.com/photo-1587745416684-47953f16f02f?auto=format&fit=crop&w=900&q=84" alt="Ambulance outside a hospital">
</section>

<section class="section testimonials-section">
    <x-site.section-title eyebrow="Testimonials" title="What patients say" description="Realistic patient stories from departments across AarogyaCare." align="center" />
    <div class="swiper testimonial-swiper">
        <div class="swiper-wrapper">
            @foreach($testimonials as $testimonial)
                <article class="swiper-slide testimonial-card">
                    <img loading="lazy" src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}">
                    <div class="stars" aria-label="5 star rating">
                        @foreach(range(1, 5) as $star)
                            <i class="fa-solid fa-star"></i>
                        @endforeach
                    </div>
                    <p>{{ $testimonial['review'] }}</p>
                    <strong>{{ $testimonial['name'] }}</strong>
                    <span>{{ $testimonial['visited'] }} Patient</span>
                </article>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<section class="section blog-section">
    <x-site.section-title eyebrow="Latest Blog" title="Health insights from our care teams" align="center" />
    <div class="blog-grid">
        @foreach($blogs as $blog)
            <article class="blog-card hover-lift">
                <img loading="lazy" src="{{ $blog['image'] }}" alt="{{ $blog['title'] }}">
                <div>
                    <span>{{ $blog['date'] }} - {{ $blog['category'] }}</span>
                    <h3>{{ $blog['title'] }}</h3>
                    <p>By {{ $blog['author'] }}</p>
                    <a href="{{ route('public.page', 'blog') }}">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="section faq-section">
    <x-site.section-title eyebrow="FAQ" title="Answers before your visit" description="Search common questions about appointments, emergency care, records, insurance, and billing." align="center" />
    <label class="faq-search"><i class="fa-solid fa-magnifying-glass"></i><input data-faq-search type="search" placeholder="Search FAQ"></label>
    <div class="faq-list">
        @foreach($faqs as $question => $answer)
            <details class="faq-item" data-faq-item>
                <summary>{{ $question }}</summary>
                <p>{{ $answer }}</p>
            </details>
        @endforeach
    </div>
</section>

<section class="section partners-section">
    <x-site.section-title eyebrow="Insurance Partners" title="Cashless and supported insurance workflows" align="center" />
    <div class="partner-strip">
        @foreach(['CareShield', 'Star Health', 'Aetna Global', 'Bajaj Health', 'MediSecure', 'LifeCover'] as $partner)
            <span>{{ $partner }}</span>
        @endforeach
    </div>
</section>

<section class="section gallery-section">
    <x-site.section-title eyebrow="Gallery" title="Inside AarogyaCare" align="center" />
    <div class="gallery-grid">
        @foreach(['https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&w=900&q=84','https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=900&q=84','https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=900&q=84','https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?auto=format&fit=crop&w=900&q=84','https://images.unsplash.com/photo-1586773860418-d37222d8fce3?auto=format&fit=crop&w=900&q=84','https://images.unsplash.com/photo-1538108149393-fbbd81895907?auto=format&fit=crop&w=900&q=84'] as $image)
            <button data-gallery-image="{{ $image }}" aria-label="Open hospital gallery image"><img loading="lazy" src="{{ $image }}" alt="AarogyaCare hospital gallery"></button>
        @endforeach
    </div>
</section>

<section class="section app-download">
    <div>
        <x-site.section-title eyebrow="Mobile App" title="Carry your hospital in your pocket" description="Appointments, reports, prescriptions, bills, insurance, and notifications stay connected through the AarogyaCare app." />
        <div class="store-buttons">
            <a href="#"><i class="fa-brands fa-google-play"></i><span>Android</span></a>
            <a href="#"><i class="fa-brands fa-apple"></i><span>iOS</span></a>
        </div>
    </div>
    <div class="qr-card" aria-label="QR code preview">
        <span></span><span></span><span></span><span></span>
        <strong>Scan App</strong>
    </div>
</section>

<section class="newsletter-band">
    <div>
        <span class="eyebrow">Newsletter</span>
        <h2>Get monthly health guidance from AarogyaCare doctors.</h2>
    </div>
    <form data-newsletter-form>
        <label class="sr-only" for="newsletter-email">Email</label>
        <input id="newsletter-email" type="email" placeholder="Enter email address" required>
        <button class="btn btn-primary ripple" type="submit">Subscribe</button>
    </form>
</section>

<section class="map-preview">
    <div>
        <span class="eyebrow">Hospital Location</span>
        <h2>AarogyaCare, Bengaluru</h2>
        <p>Outer Ring Road, near HealthTech Park, Bengaluru, Karnataka 560103</p>
        <a class="btn btn-primary ripple" href="https://maps.google.com/?q=Bengaluru%20hospital" target="_blank" rel="noopener">Get Direction</a>
    </div>
    <iframe title="AarogyaCare map preview" loading="lazy" src="https://maps.google.com/maps?q=Bengaluru%20hospital&t=&z=12&ie=UTF8&iwloc=&output=embed"></iframe>
</section>

<div class="gallery-lightbox" data-gallery-lightbox hidden>
    <button class="icon-button" data-gallery-close aria-label="Close image"><i class="fa-solid fa-xmark"></i></button>
    <img src="" alt="Expanded AarogyaCare gallery">
</div>
@endsection
