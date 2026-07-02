<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Executive Analytics BI' }} | AarogyaCare</title>
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
            --brand-gradient: linear-gradient(135deg, #0f6fff, #8b5cf6);
        }

        [data-theme="dark"] {
            --glass-bg: rgba(13, 27, 46, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(15, 111, 255, 0.03) 0%, rgba(139, 92, 246, 0.02) 90%);
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
            border-color: rgba(15, 111, 255, 0.25);
        }

        .bi-sidebar {
            background: var(--glass-bg);
            border-right: 1px solid var(--glass-border);
            backdrop-filter: blur(12px);
        }

        .nav-item-active {
            background: var(--brand-gradient);
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(15, 111, 255, 0.25);
        }
    </style>
</head>
<body>
    <div class="dashboard-shell">
        <!-- Sidebar -->
        <aside class="sidebar bi-sidebar">
            <a class="brand" href="/">
                <span class="brand-mark" style="background:var(--brand-gradient);"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Medova BI</span>
            </a>
            
            <nav aria-label="BI Navigation" style="max-height:80vh; overflow-y:auto; padding-bottom:20px;">
                <a href="{{ route('analytics.dashboard') }}" class="{{ Route::currentRouteName() === 'analytics.dashboard' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('analytics.revenue') }}" class="{{ Route::currentRouteName() === 'analytics.revenue' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-indian-rupee-sign"></i><span>Revenue BI</span>
                </a>
                <a href="{{ route('analytics.patients') }}" class="{{ Route::currentRouteName() === 'analytics.patients' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-user-injured"></i><span>Patient growth</span>
                </a>
                <a href="{{ route('analytics.doctors') }}" class="{{ Route::currentRouteName() === 'analytics.doctors' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-user-doctor"></i><span>Doctor rating</span>
                </a>
                <a href="{{ route('analytics.departments') }}" class="{{ Route::currentRouteName() === 'analytics.departments' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-hospital-user"></i><span>Departments</span>
                </a>
                <a href="{{ route('analytics.pharmacy') }}" class="{{ Route::currentRouteName() === 'analytics.pharmacy' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-prescription-bottle-medical"></i><span>Pharmacy</span>
                </a>
                <a href="{{ route('analytics.laboratory') }}" class="{{ Route::currentRouteName() === 'analytics.laboratory' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-flask-vial"></i><span>Laboratory</span>
                </a>
                <a href="{{ route('analytics.inventory') }}" class="{{ Route::currentRouteName() === 'analytics.inventory' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-boxes-stacked"></i><span>Inventory value</span>
                </a>
                <a href="{{ route('analytics.hr') }}" class="{{ Route::currentRouteName() === 'analytics.hr' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-people-group"></i><span>HR Attendance</span>
                </a>
                <a href="{{ route('analytics.appointments') }}" class="{{ Route::currentRouteName() === 'analytics.appointments' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i><span>Visits Density</span>
                </a>
                <a href="{{ route('analytics.finance') }}" class="{{ Route::currentRouteName() === 'analytics.finance' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i><span>Finance metrics</span>
                </a>
                <a href="{{ route('analytics.forecast') }}" class="{{ Route::currentRouteName() === 'analytics.forecast' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-arrow-trend-up"></i><span>Forecasting Model</span>
                </a>
                <a href="{{ route('analytics.audit') }}" class="{{ Route::currentRouteName() === 'analytics.audit' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-shield-halved"></i><span>Audit timelines</span>
                </a>
                <a href="{{ route('analytics.reports') }}" class="{{ Route::currentRouteName() === 'analytics.reports' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text"></i><span>Schedules</span>
                </a>
                <a href="{{ route('analytics.settings') }}" class="{{ Route::currentRouteName() === 'analytics.settings' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-sliders"></i><span>Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Main Body -->
        <main class="dashboard-main">
            <!-- Topbar -->
            <header class="dashboard-topbar">
                <div>
                    <h1>{{ $title ?? 'Executive Analytics BI' }}</h1>
                    <p style="color:var(--text-muted); font-size: 13.5px; margin: 4px 0 0;">ERP Business Intelligence Center</p>
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
