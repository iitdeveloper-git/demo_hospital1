@php($navItems = ['home' => route('home'), 'about' => route('public.page', 'about'), 'departments' => route('public.page', 'departments'), 'doctors' => route('public.page', 'doctors'), 'services' => route('public.page', 'services'), 'health packages' => route('public.page', 'health-packages'), 'gallery' => route('public.page', 'gallery'), 'blog' => route('public.page', 'blog'), 'faq' => route('public.page', 'faq'), 'contact' => route('public.page', 'contact')])
<header class="site-header premium-header" data-site-header>
    <a class="brand" href="{{ route('home') }}" aria-label="AarogyaCare home">
        <span class="brand-mark"><i class="fa-solid fa-heart-pulse"></i></span>
        <span>AarogyaCare</span>
    </a>

    <button class="mobile-menu-button" data-mobile-menu-button aria-label="Open mobile menu" aria-expanded="false">
        <i class="fa-solid fa-bars"></i>
    </button>

    <nav class="site-nav mega-nav" data-mobile-menu aria-label="Primary navigation">
        @foreach($navItems as $label => $url)
            <a href="{{ $url }}">{{ str($label)->title() }}</a>
        @endforeach
    </nav>

    <div class="header-actions">
        <button class="icon-button" data-search-toggle aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        <button class="icon-button notification-button" aria-label="Notifications"><i class="fa-regular fa-bell"></i><span></span></button>
        <button class="icon-button" data-theme-toggle aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
        <a class="btn btn-primary ripple" href="{{ route('public.page', 'appointment') }}">Book Appointment</a>
    </div>
</header>

<div class="search-overlay" data-search-overlay hidden>
    <div class="search-dialog" role="dialog" aria-modal="true" aria-label="Site search">
        <button class="icon-button" data-search-close aria-label="Close search"><i class="fa-solid fa-xmark"></i></button>
        <label>
            Search AarogyaCare
            <input type="search" placeholder="Search departments, doctors, packages..." data-global-search>
        </label>
        <div class="search-suggestions">
            <a href="{{ route('public.page', 'doctors') }}">Find a doctor</a>
            <a href="{{ route('public.page', 'appointment') }}">Book appointment</a>
            <a href="{{ route('public.page', 'departments') }}">Browse departments</a>
        </div>
    </div>
</div>
