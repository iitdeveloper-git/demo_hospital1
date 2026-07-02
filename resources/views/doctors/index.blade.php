@extends('layouts.public')

@section('content')
<div class="doctors-list-page">
    <!-- Hero Banner -->
    <section class="page-banner doctors-hero" style="background-image: linear-gradient(rgba(11, 36, 84, 0.88), rgba(11, 36, 84, 0.95)), url('{{ asset('public/images/hospital.png') }}');">
        <div class="banner-content">
            <nav class="about-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">Doctors</span>
            </nav>
            <h1>Meet Our Specialist Doctors</h1>
            <p>Consult with highly experienced medical professionals committed to clinical excellence.</p>
        </div>
    </section>

    <!-- Toolbar & Main Grid Layout -->
    <section class="section doctors-showcase-section">
        <div class="doctors-layout-container">
            <!-- Advanced Sidebar Filters -->
            <aside class="doctors-sidebar-filters">
                <form action="{{ route('doctors.index') }}" method="GET" class="filters-form">
                    <!-- Search Input -->
                    <div class="filter-group">
                        <label for="doctor-search">Search Doctor</label>
                        <div class="search-field-wrap">
                            <i class="fa-solid fa-magnifying-glass field-icon"></i>
                            <input type="text" id="doctor-search" name="search" placeholder="Name, Specialization..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Department Category Filter -->
                    <div class="filter-group">
                        <label for="filter-dept">Department</label>
                        <select id="filter-dept" name="department">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->slug }}" {{ request('department') == $dept->slug ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div class="filter-group">
                        <label>Gender</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }}> All
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}> Male
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="gender" value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}> Female
                            </label>
                        </div>
                    </div>

                    <!-- Experience Filter -->
                    <div class="filter-group">
                        <label for="filter-exp">Experience</label>
                        <select id="filter-exp" name="experience">
                            <option value="">Any Experience</option>
                            <option value="5" {{ request('experience') == '5' ? 'selected' : '' }}>5+ Years</option>
                            <option value="10" {{ request('experience') == '10' ? 'selected' : '' }}>10+ Years</option>
                            <option value="15" {{ request('experience') == '15' ? 'selected' : '' }}>15+ Years</option>
                            <option value="20" {{ request('experience') == '20' ? 'selected' : '' }}>20+ Years</option>
                        </select>
                    </div>

                    <!-- Availability & Consultations -->
                    <div class="filter-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="available_today" value="1" {{ request('available_today') ? 'checked' : '' }}> Available Today
                        </label>
                        <label class="checkbox-label">
                            <input type="checkbox" name="video_consultation" value="1" {{ request('video_consultation') ? 'checked' : '' }}> Video Consultation
                        </label>
                    </div>

                    <!-- Rating Filter -->
                    <div class="filter-group">
                        <label for="filter-rating">Rating</label>
                        <select id="filter-rating" name="rating">
                            <option value="">Any Rating</option>
                            <option value="4.5" {{ request('rating') == '4.5' ? 'selected' : '' }}>4.5+ Stars</option>
                            <option value="4.8" {{ request('rating') == '4.8' ? 'selected' : '' }}>4.8+ Stars</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary full-width-btn">Apply Filters</button>
                    <a href="{{ route('doctors.index') }}" class="btn btn-soft full-width-btn reset-btn">Reset Filters</a>
                </form>
            </aside>

            <!-- Main Doctors List Area -->
            <div class="doctors-main-grid">
                <!-- Sorting & Grid Toggles -->
                <div class="grid-toolbar">
                    <span class="results-count">Showing <strong>{{ $doctors->count() }}</strong> specialist clinicians</span>
                    <div class="grid-toolbar-actions">
                        <label for="sort-select" class="sr-only">Sort by</label>
                        <select id="sort-select" onchange="location = this.value;" aria-label="Sort doctors">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'rating_desc']) }}" {{ request('sort') == 'rating_desc' || !request('sort') ? 'selected' : '' }}>Top Rated</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'experience_desc']) }}" {{ request('sort') == 'experience_desc' ? 'selected' : '' }}>Most Experienced</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'fee_asc']) }}" {{ request('sort') == 'fee_asc' ? 'selected' : '' }}>Fee: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'fee_desc']) }}" {{ request('sort') == 'fee_desc' ? 'selected' : '' }}>Fee: High to Low</option>
                        </select>
                        
                        <div class="layout-toggles">
                            <button class="toggle-btn active" id="grid-view-btn" onclick="setDocLayout('grid')" aria-label="Grid view"><i class="fa-solid fa-grid-2"></i></button>
                            <button class="toggle-btn" id="list-view-btn" onclick="setDocLayout('list')" aria-label="List view"><i class="fa-solid fa-list"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Doctors Wrapper -->
                <div class="doctors-cards-container grid-layout" id="doctors-container">
                    @forelse($doctors as $doctor)
                        <article class="doctor-card-premium hover-lift" data-aos="fade-up">
                            <div class="doc-card-head">
                                <img loading="lazy" src="{{ asset($doctor->photo ?? 'public/images/dr_aanya_sharma.png') }}" alt="{{ $doctor->full_name }}">
                                @if($doctor->available_today)
                                    <span class="badge-available"><span class="pulse-dot"></span> Available Today</span>
                                @endif
                            </div>
                            <div class="doc-card-body">
                                <span class="doc-dept-label"><i class="fa-solid {{ $doctor->department->icon ?? 'fa-stethoscope' }}"></i> {{ $doctor->department->name }}</span>
                                <h3>{{ $doctor->full_name }}</h3>
                                <span class="doc-specialization">{{ $doctor->qualification }} - {{ $doctor->specialization }}</span>
                                
                                <div class="doc-meta-stats">
                                    <span><i class="fa-solid fa-briefcase"></i> <strong>{{ $doctor->experience_years }}+</strong> Years</span>
                                    <span><i class="fa-solid fa-star"></i> <strong>{{ $doctor->rating }}</strong> ({{ $doctor->review_count }} Reviews)</span>
                                </div>

                                <div class="doc-fee-box">
                                    <span>OPD Fee: <strong>₹{{ number_format($doctor->consultation_fee, 0) }}</strong></span>
                                    @if($doctor->video_consultation)
                                        <span class="video-badge"><i class="fa-solid fa-video"></i> Video Online</span>
                                    @endif
                                </div>

                                <div class="doc-card-footer">
                                    <a href="{{ route('public.page', ['page' => 'appointment']) }}?doctor={{ urlencode($doctor->full_name) }}&department={{ urlencode($doctor->department->name) }}" class="btn btn-primary">Book Visit</a>
                                    <a href="{{ route('doctors.show', $doctor->slug) }}" class="btn btn-soft">Profile</a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="no-results">
                            <i class="fa-solid fa-user-doctor"></i>
                            <h3>No Doctors Found</h3>
                            <p>Try clearing filters or search query to explore other available clinicians.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="pagination-wrap">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </section>
</div>

<style>
/* Premium Styles for Doctors Showcase */
.doctors-hero {
    height: 35vh;
    min-height: 280px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
}

.doctors-layout-container {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 36px;
    align-items: start;
}

.doctors-sidebar-filters {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 24px;
    box-shadow: var(--shadow);
}

.filter-group {
    margin-bottom: 20px;
}

.filter-group label {
    margin-bottom: 8px;
}

.search-field-wrap {
    position: relative;
}

.search-field-wrap input {
    padding-left: 42px;
}

.field-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
}

.radio-group, .checkbox-group {
    display: grid;
    gap: 8px;
}

.radio-label, .checkbox-label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-weight: 500;
}

.full-width-btn {
    width: 100%;
    margin-bottom: 12px;
}

.reset-btn {
    text-align: center;
}

/* Main Grid & Cards */
.grid-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 16px;
}

.grid-toolbar-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.grid-toolbar-actions select {
    padding: 10px 32px 10px 14px;
    background-color: var(--white);
    border: 1px solid var(--line);
    border-radius: 8px;
    cursor: pointer;
}

.doctors-cards-container {
    display: grid;
    gap: 24px;
}

.doctors-cards-container.grid-layout {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.doctors-cards-container.list-layout {
    grid-template-columns: 1fr;
}

.doctor-card-premium {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
}

.doctors-cards-container.list-layout .doctor-card-premium {
    flex-direction: row;
    align-items: center;
}

.doc-card-head {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.doctors-cards-container.list-layout .doc-card-head {
    width: 250px;
    height: 100%;
    min-height: 250px;
    flex-shrink: 0;
}

.doc-card-head img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.badge-available {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(34, 197, 94, 0.9);
    color: #fff;
    padding: 4px 10px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.pulse-dot {
    width: 6px;
    height: 6px;
    background: #fff;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(0.9); opacity: 0.6; }
    50% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(0.9); opacity: 0.6; }
}

.doc-card-body {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.doc-dept-label {
    font-size: 12px;
    color: var(--teal);
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 8px;
}

.doc-card-body h3 {
    margin: 0 0 4px;
    font-size: 18px;
    color: var(--blue-900);
}

.doc-specialization {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 16px;
}

.doc-meta-stats {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    padding: 10px 0;
    margin-bottom: 16px;
    font-size: 12px;
    color: var(--muted);
}

.doc-meta-stats i {
    color: var(--blue-600);
}

.doc-fee-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--muted);
}

.video-badge {
    background: var(--soft);
    color: var(--blue-600);
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 700;
}

.doc-card-footer {
    display: flex;
    gap: 12px;
}

.doc-card-footer .btn {
    flex: 1;
}

.no-results {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
}

.no-results i {
    font-size: 48px;
    color: var(--muted);
    margin-bottom: 16px;
}

.pagination-wrap {
    margin-top: 48px;
    display: flex;
    justify-content: center;
}

@media (max-width: 980px) {
    .doctors-layout-container {
        grid-template-columns: 1fr;
    }
    .doctors-cards-container.grid-layout {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .doctors-cards-container.grid-layout {
        grid-template-columns: 1fr;
    }
    .doctors-cards-container.list-layout .doctor-card-premium {
        flex-direction: column;
    }
    .doctors-cards-container.list-layout .doc-card-head {
        width: 100%;
        height: 250px;
    }
}
</style>

<script>
function setDocLayout(type) {
    const container = document.getElementById('doctors-container');
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');
    
    if (type === 'grid') {
        container.classList.remove('list-layout');
        container.classList.add('grid-layout');
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    } else {
        container.classList.remove('grid-layout');
        container.classList.add('list-layout');
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    }
}
</script>
@endsection
