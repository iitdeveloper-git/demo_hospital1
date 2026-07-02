<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Hospital CMS Manager' }} | AarogyaCare</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('resources/css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <style>
        :root {
            --glass-bg: rgba(255, 255, 255, 0.45);
            --glass-border: rgba(15, 111, 255, 0.12);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.06);
            --brand-gradient: linear-gradient(135deg, #14b8a6, #0ea5e9);
        }

        [data-theme="dark"] {
            --glass-bg: rgba(13, 27, 46, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(20, 184, 166, 0.03) 0%, rgba(14, 165, 233, 0.02) 90%);
        }

        .glass-panel {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            box-shadow: var(--glass-shadow);
            padding: 24px;
            transition: all 0.3s ease;
        }

        .glass-panel:hover {
            border-color: rgba(20, 184, 166, 0.25);
        }

        .cms-sidebar {
            background: var(--glass-bg);
            border-right: 1px solid var(--glass-border);
            backdrop-filter: blur(12px);
        }

        .nav-item-active {
            background: var(--brand-gradient);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(20, 184, 166, 0.25);
        }
    </style>
</head>
<body>
    <div class="dashboard-shell">
        <!-- Sidebar -->
        <aside class="sidebar cms-sidebar">
            <a class="brand" href="/">
                <span class="brand-mark" style="background:var(--brand-gradient);"><i class="fa-solid fa-pager"></i></span>
                <span>Medova CMS</span>
            </a>
            
            <nav aria-label="CMS Navigation" style="max-height:80vh; overflow-y:auto; padding-bottom:20px;">
                <a href="{{ route('cms.dashboard') }}" class="{{ Route::currentRouteName() === 'cms.dashboard' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i><span>CMS Dashboard</span>
                </a>
                <a href="{{ route('cms.pages') }}" class="{{ Route::currentRouteName() === 'cms.pages' || Route::currentRouteName() === 'cms.builder' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-file-signature"></i><span>Page Builder</span>
                </a>
                <a href="{{ route('cms.blog') }}" class="{{ Route::currentRouteName() === 'cms.blog' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-square-rss"></i><span>Blog System</span>
                </a>
                <a href="{{ route('cms.news') }}" class="{{ Route::currentRouteName() === 'cms.news' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-newspaper"></i><span>Newsroom</span>
                </a>
                <a href="{{ route('cms.events') }}" class="{{ Route::currentRouteName() === 'cms.events' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-calendar-days"></i><span>Events</span>
                </a>
                <a href="{{ route('cms.careers') }}" class="{{ Route::currentRouteName() === 'cms.careers' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-briefcase"></i><span>Careers Portal</span>
                </a>
                <a href="{{ route('cms.testimonials') }}" class="{{ Route::currentRouteName() === 'cms.testimonials' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-quote-left"></i><span>Testimonials</span>
                </a>
                <a href="{{ route('cms.faqs') }}" class="{{ Route::currentRouteName() === 'cms.faqs' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-question-circle"></i><span>FAQs System</span>
                </a>
                <a href="{{ route('cms.newsletter') }}" class="{{ Route::currentRouteName() === 'cms.newsletter' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text"></i><span>Newsletter Sub</span>
                </a>
                <a href="{{ route('cms.campaigns') }}" class="{{ Route::currentRouteName() === 'cms.campaigns' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-bullhorn"></i><span>Marketing Campaigns</span>
                </a>
                <a href="{{ route('cms.contact') }}" class="{{ Route::currentRouteName() === 'cms.contact' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-inbox"></i><span>Forms Inbox</span>
                </a>
                <a href="{{ route('cms.seo') }}" class="{{ Route::currentRouteName() === 'cms.seo' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-magnifying-glass-chart"></i><span>SEO Management</span>
                </a>
                <a href="{{ route('cms.settings') }}" class="{{ Route::currentRouteName() === 'cms.settings' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-sliders"></i><span>Branding Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Body -->
        <main class="dashboard-main">
            <!-- Topbar -->
            <header class="dashboard-topbar">
                <div>
                    <h1>{{ $title ?? 'Hospital CMS Manager' }}</h1>
                    <p style="color:var(--text-muted); font-size: 13.5px; margin: 4px 0 0;">Public Website Configurator</p>
                </div>
                <div class="header-actions">
                    <button class="icon-button" onclick="toggleTheme()" aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
                    
                    @auth
                        <div style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:12px; font-weight:700;">{{ Auth::user()->name }}</span>
                            <span class="pill" style="text-transform:uppercase; font-size:10px;">{{ Auth::user()->role->name }}</span>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Toast alert -->
            @if(session('success'))
                <div class="toast"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif

            <!-- Content Slot -->
            @yield('content')
        </main>
    </div>

    <script>
        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const targetTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', targetTheme);
            localStorage.setItem('theme', targetTheme);
        }
        
        // Load preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</body>
</html>
