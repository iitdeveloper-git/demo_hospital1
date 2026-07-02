@extends('layouts.public')

@section('content')
<div class="services-list-page">
    <!-- Hero Banner -->
    <section class="page-banner services-hero" style="background-image: linear-gradient(rgba(11, 36, 84, 0.88), rgba(11, 36, 84, 0.95)), url('{{ asset('public/images/hospital.png') }}');">
        <div class="banner-content">
            <nav class="about-breadcrumbs" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">Services</span>
            </nav>
            <h1>Healthcare Services & Treatments</h1>
            <p>World-class clinical specialties powered by advanced AI workflows and compassionate care teams.</p>
        </div>
    </section>

    <!-- Toolbar & Filters -->
    <section class="section services-toolbar-section">
        <div class="toolbar-container">
            <!-- Search Bar -->
            <form action="{{ route('services.index') }}" method="GET" class="services-search-form">
                @if(request('department'))
                    <input type="hidden" name="department" value="{{ request('department') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="search" placeholder="Search medical services..." value="{{ request('search') }}" aria-label="Search services">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <div class="toolbar-actions">
                <!-- Sorting -->
                <div class="sorting-wrapper">
                    <label for="services-sort" class="sr-only">Sort Services</label>
                    <select id="services-sort" onchange="location = this.value;" aria-label="Sort services">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'default']) }}" {{ request('sort') == 'default' || !request('sort') ? 'selected' : '' }}>Latest</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'title_asc']) }}" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'title_desc']) }}" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Name: Z to A</option>
                    </select>
                </div>

                <!-- Grid/List Toggle -->
                <div class="layout-toggles">
                    <button class="toggle-btn active" id="grid-toggle" onclick="toggleLayout('grid')" aria-label="Grid View"><i class="fa-solid fa-grid-2"></i> Grid</button>
                    <button class="toggle-btn" id="list-toggle" onclick="toggleLayout('list')" aria-label="List View"><i class="fa-solid fa-list"></i> List</button>
                </div>
            </div>
        </div>

        <!-- Category/Department Filter -->
        <div class="category-filters-scroll">
            <div class="category-filters">
                <a href="{{ request()->fullUrlWithQuery(['department' => null]) }}" class="filter-chip {{ !request('department') ? 'active' : '' }}">All Services</a>
                @foreach($departments as $dept)
                    <a href="{{ request()->fullUrlWithQuery(['department' => $dept->slug]) }}" class="filter-chip {{ request('department') == $dept->slug ? 'active' : '' }}">
                        <i class="fa-solid {{ $dept->icon ?? 'fa-stethoscope' }}"></i> {{ $dept->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="section services-grid-section">
        <div class="services-wrapper grid-layout" id="services-container">
            @forelse($services as $service)
                <article class="service-card-premium hover-lift" data-aos="fade-up">
                    <div class="card-image-wrap">
                        <img loading="lazy" src="{{ asset($service->featured_image) }}" alt="{{ $service->title }}">
                        <span class="card-dept-badge">
                            <i class="fa-solid {{ $service->icon }}"></i> {{ $service->department->name }}
                        </span>
                    </div>
                    <div class="card-content-wrap">
                        <h3>{{ $service->title }}</h3>
                        <p class="card-desc">{{ $service->short_description }}</p>
                        
                        <div class="card-meta-info">
                            <span class="meta-item"><i class="fa-solid fa-indian-rupee-sign"></i> Starting from <strong>₹{{ number_format($service->price_from, 0) }}</strong></span>
                            <span class="meta-item"><i class="fa-solid fa-clock"></i> {{ $service->duration }}</span>
                        </div>
                        
                        <div class="card-footer-actions">
                            <a href="{{ route('public.page', ['page' => 'appointment']) }}?service={{ urlencode($service->title) }}&department={{ urlencode($service->department->name) }}" class="btn btn-primary">Book Visit</a>
                            <a href="{{ route('services.show', $service->slug) }}" class="btn btn-soft">Read More</a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="no-services-found">
                    <i class="fa-solid fa-folder-open"></i>
                    <h3>No Services Found</h3>
                    <p>Try refining your search or choosing a different specialty filter.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="services-pagination">
            {{ $services->links() }}
        </div>
    </section>
</div>

<style>
/* Premium Styles for Services Showcase */
.services-hero {
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

.about-breadcrumbs {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 13px;
    margin-bottom: 16px;
    border: 1px solid rgba(255, 255, 255, 0.15);
}

.about-breadcrumbs a {
    color: #bfdbfe;
    text-decoration: none;
}

.about-breadcrumbs .separator {
    color: rgba(255, 255, 255, 0.4);
    font-size: 10px;
}

.services-hero h1 {
    font-size: clamp(28px, 5vw, 48px);
    margin: 0 0 10px;
}

.services-toolbar-section {
    padding-bottom: 0;
}

.toolbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}

.services-search-form {
    flex: 1;
    min-width: 280px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    gap: 12px;
}

.search-input-wrapper input {
    padding-left: 44px;
}

.search-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--muted);
}

.toolbar-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.sorting-wrapper select {
    padding: 10px 32px 10px 14px;
    background-color: var(--white);
    border: 1px solid var(--line);
    border-radius: 8px;
    cursor: pointer;
}

.layout-toggles {
    display: flex;
    border: 1px solid var(--line);
    border-radius: 8px;
    overflow: hidden;
}

.toggle-btn {
    padding: 10px 16px;
    background: var(--white);
    border: 0;
    cursor: pointer;
    font-weight: 600;
    color: var(--muted);
}

.toggle-btn.active {
    background: var(--soft);
    color: var(--blue-600);
}

.category-filters-scroll {
    overflow-x: auto;
    padding-bottom: 8px;
    margin-top: 16px;
}

.category-filters {
    display: flex;
    gap: 12px;
    white-space: nowrap;
}

.filter-chip {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border: 1px solid var(--line);
    border-radius: 99px;
    background: var(--white);
    color: var(--muted);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}

.filter-chip.active, .filter-chip:hover {
    background: var(--blue-600);
    color: #fff;
    border-color: var(--blue-600);
}

/* Service Card Layouts */
.services-wrapper {
    display: grid;
    gap: 24px;
    margin-top: 32px;
}

.services-wrapper.grid-layout {
    grid-template-columns: repeat(3, minmax(0, 1fr));
}

.services-wrapper.list-layout {
    grid-template-columns: 1fr;
}

.service-card-premium {
    background: var(--white);
    border: 1px solid var(--line);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
    display: flex;
    flex-direction: column;
}

.services-wrapper.list-layout .service-card-premium {
    flex-direction: row;
    align-items: center;
}

.card-image-wrap {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.services-wrapper.list-layout .card-image-wrap {
    width: 320px;
    height: 100%;
    min-height: 220px;
    flex-shrink: 0;
}

.card-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s;
}

.service-card-premium:hover .card-image-wrap img {
    transform: scale(1.04);
}

.card-dept-badge {
    position: absolute;
    top: 16px;
    left: 16px;
    background: rgba(11, 36, 84, 0.76);
    backdrop-filter: blur(8px);
    color: #fff;
    padding: 6px 12px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid rgba(255,255,255,0.15);
}

.card-content-wrap {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-content-wrap h3 {
    margin: 0 0 10px;
    font-size: 20px;
    color: var(--blue-900);
}

.card-desc {
    color: var(--muted);
    font-size: 14px;
    line-height: 1.6;
    margin: 0 0 20px;
    flex: 1;
}

.card-meta-info {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid var(--line);
    border-bottom: 1px solid var(--line);
    padding: 12px 0;
    margin-bottom: 20px;
    font-size: 13px;
    color: var(--muted);
}

.card-meta-info i {
    color: var(--blue-600);
}

.card-footer-actions {
    display: flex;
    gap: 12px;
}

.card-footer-actions .btn {
    flex: 1;
}

.no-services-found {
    grid-column: 1 / -1;
    text-align: center;
    padding: 64px 24px;
}

.no-services-found i {
    font-size: 48px;
    color: var(--muted);
    margin-bottom: 16px;
}

.services-pagination {
    margin-top: 48px;
    display: flex;
    justify-content: center;
}

@media (max-width: 980px) {
    .services-wrapper.grid-layout {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 640px) {
    .services-wrapper.grid-layout {
        grid-template-columns: 1fr;
    }
    .services-wrapper.list-layout .service-card-premium {
        flex-direction: column;
    }
    .services-wrapper.list-layout .card-image-wrap {
        width: 100%;
        height: 200px;
    }
}
</style>

<script>
function toggleLayout(type) {
    const container = document.getElementById('services-container');
    const gridBtn = document.getElementById('grid-toggle');
    const listBtn = document.getElementById('list-toggle');
    
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
