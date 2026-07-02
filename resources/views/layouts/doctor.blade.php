<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Clinical Portal' }} | AarogyaCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="portal-body">
    <div class="portal-container" id="portalContainer">
        <!-- Sidebar -->
        <aside class="portal-sidebar" id="portalSidebar">
            <div class="sidebar-brand">
                <a href="{{ route('home') }}">
                    <span class="brand-icon"><i class="fa-solid fa-heart-pulse"></i></span>
                    <span class="brand-text">AarogyaCare</span>
                </a>
                <button class="sidebar-toggle-btn" id="sidebarCollapseBtn" aria-label="Collapse sidebar">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            </div>
            
            <div class="sidebar-user">
                <div class="user-avatar-wrap">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                    @else
                        <span class="avatar-initials">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    @endif
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Specialist ({{ Auth::user()->doctor?->employee_id }})</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('doctor.dashboard') }}" class="{{ Route::currentRouteName() === 'doctor.dashboard' ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i><span>Command Center</span>
                </a>
                <a href="{{ route('doctor.profile') }}" class="{{ Route::currentRouteName() === 'doctor.profile' ? 'active' : '' }}">
                    <i class="fa-solid fa-user-md"></i><span>Clinical Profile</span>
                </a>
                <a href="{{ route('doctor.schedule') }}" class="{{ Route::currentRouteName() === 'doctor.schedule' ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-alt"></i><span>My Schedule</span>
                </a>
                <a href="{{ route('doctor.appointments') }}" class="{{ Route::currentRouteName() === 'doctor.appointments' ? 'active' : '' }}">
                    <i class="fa-solid fa-clock"></i><span>Appointments</span>
                </a>
                <a href="{{ route('doctor.patients') }}" class="{{ Route::currentRouteName() === 'doctor.patients' || Route::currentRouteName() === 'doctor.patient.show' ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i><span>Patients Registry</span>
                </a>
                <a href="{{ route('doctor.prescriptions') }}" class="{{ Route::currentRouteName() === 'doctor.prescriptions' ? 'active' : '' }}">
                    <i class="fa-solid fa-prescription"></i><span>Prescriptions</span>
                </a>
                <a href="{{ route('doctor.reports') }}" class="{{ Route::currentRouteName() === 'doctor.reports' ? 'active' : '' }}">
                    <i class="fa-solid fa-flask"></i><span>Lab & Diagnostics</span>
                </a>
                <a href="{{ route('doctor.messages') }}" class="{{ Route::currentRouteName() === 'doctor.messages' ? 'active' : '' }}">
                    <i class="fa-solid fa-comments"></i><span>Secure Messages</span>
                </a>
                <a href="{{ route('ai.dashboard') }}">
                    <i class="fa-solid fa-microchip-ai"></i><span>AI Clinical Assistant</span>
                </a>
                <a href="{{ route('doctor.settings') }}" class="{{ Route::currentRouteName() === 'doctor.settings' ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i><span>Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form action="{{ route('doctor.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i><span>Log Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="portal-main">
            <header class="portal-topbar">
                <div class="topbar-left">
                    <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle mobile menu">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <span class="topbar-title">{{ $title ?? 'Clinical Portal' }}</span>
                </div>
                <div class="topbar-right">
                    <button class="topbar-action-btn" data-theme-toggle aria-label="Toggle dark mode">
                        <i class="fa-solid fa-moon"></i>
                    </button>
                    <div class="topbar-divider"></div>
                    <div class="topbar-user-menu">
                        <span class="user-greeting">Welcome, <strong>{{ explode(' ', Auth::user()->name)[0] }}</strong></span>
                    </div>
                </div>
            </header>

            <main class="portal-content">
                @yield('content')
            </main>
        </div>
    </div>

    @if(session('toast'))
        <div class="toast is-visible" role="status">{{ session('toast.message') }}</div>
    @endif

    <style>
        /* Custom Portal CSS */
        :root {
            --portal-sidebar-width: 260px;
            --portal-sidebar-collapsed-width: 70px;
            --portal-header-height: 64px;
            
            --bg-primary: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            
            --brand-primary: #0284c7;
            --brand-hover: #0369a1;
            --brand-soft: rgba(2, 132, 199, 0.08);
            
            --sidebar-bg: #ffffff;
            --sidebar-color: #334155;
            --sidebar-active-bg: var(--brand-soft);
            --sidebar-active-color: var(--brand-primary);
        }

        [data-theme="dark"] {
            --bg-primary: #0b0f19;
            --bg-card: #131c2e;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #1e293b;
            
            --sidebar-bg: #0f172a;
            --sidebar-color: #94a3b8;
            --sidebar-active-bg: rgba(2, 132, 199, 0.15);
            --sidebar-active-color: #38bdf8;
        }

        body.portal-body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .portal-container {
            display: flex;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar styling */
        .portal-sidebar {
            width: var(--portal-sidebar-width);
            background-color: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            height: var(--portal-header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 18px;
        }

        .brand-icon {
            color: var(--brand-primary);
            font-size: 20px;
        }

        .sidebar-toggle-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            border-radius: 6px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .sidebar-user {
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--border-color);
            overflow: hidden;
        }

        .user-avatar-wrap {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--brand-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initials {
            font-weight: 700;
            color: var(--brand-primary);
            text-transform: uppercase;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        .sidebar-nav {
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-grow: 1;
            overflow-y: auto;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            text-decoration: none;
            color: var(--sidebar-color);
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar-nav a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav a:hover {
            background-color: var(--bg-primary);
            color: var(--text-main);
        }

        .sidebar-nav a.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border-color);
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: none;
            border: none;
            color: #ef4444;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
            text-align: left;
        }

        .logout-btn:hover {
            background-color: rgba(239, 68, 68, 0.08);
        }

        /* Collapsed Sidebar */
        .portal-container.collapsed .portal-sidebar {
            width: var(--portal-sidebar-collapsed-width);
        }

        .portal-container.collapsed .brand-text,
        .portal-container.collapsed .user-info,
        .portal-container.collapsed .sidebar-nav span,
        .portal-container.collapsed .logout-btn span {
            display: none;
        }

        .portal-container.collapsed .sidebar-brand {
            justify-content: center;
        }

        .portal-container.collapsed .sidebar-toggle-btn {
            transform: rotate(180deg);
        }

        /* Main Portal Layout */
        .portal-main {
            flex-grow: 1;
            margin-left: var(--portal-sidebar-width);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .portal-container.collapsed .portal-main {
            margin-left: var(--portal-sidebar-collapsed-width);
        }

        .portal-topbar {
            height: var(--portal-header-height);
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-main);
            font-size: 20px;
            cursor: pointer;
        }

        .topbar-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-action-btn {
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }

        .topbar-action-btn:hover {
            background-color: var(--bg-primary);
            color: var(--text-main);
        }

        .topbar-divider {
            height: 24px;
            width: 1px;
            background-color: var(--border-color);
        }

        .user-greeting {
            font-size: 14px;
            color: var(--text-muted);
        }

        .portal-content {
            padding: 32px;
            flex-grow: 1;
            max-width: 1200px;
            width: 100%;
            box-sizing: border-box;
            margin: 0 auto;
        }

        /* Generic Helper Styles for Doctor Pages */
        .panel {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
        }

        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .panel-header h2 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-wrap {
            overflow-x: auto;
            margin: 0 -24px -24px;
        }

        .portal-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .portal-table th {
            background-color: var(--bg-primary);
            padding: 12px 24px;
            font-weight: 600;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
        }

        .portal-table td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .portal-table tr:last-child td {
            border-bottom: none;
        }

        .btn {
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--brand-primary); color: #ffffff; }
        .btn-primary:hover { background-color: var(--brand-hover); }
        .btn-secondary { background-color: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color); }
        .btn-secondary:hover { background-color: var(--bg-primary); }
        .btn-soft { background-color: var(--brand-soft); color: var(--brand-primary); }
        .btn-soft:hover { background-color: rgba(2, 132, 199, 0.15); }
        .btn-danger { background-color: #ef4444; color: #ffffff; }
        .btn-danger:hover { background-color: #dc2626; }

        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }

        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-completed, .status-final, .status-active { background-color: rgba(16, 185, 129, 0.08); color: #10b981; }
        .status-scheduled, .status-checked-in, .status-pending { background-color: rgba(2, 132, 199, 0.08); color: #0284c7; }
        .status-cancelled, .status-overdue { background-color: rgba(239, 68, 68, 0.08); color: #ef4444; }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #0f172a;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            font-size: 14px;
            z-index: 1000;
            display: none;
        }

        .toast.is-visible {
            display: block;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        /* Responsive breakpoints */
        @media (max-width: 992px) {
            .portal-sidebar {
                transform: translateX(-100%);
            }
            
            .portal-main {
                margin-left: 0 !important;
            }

            .portal-container.mobile-active .portal-sidebar {
                transform: translateX(0);
                width: var(--portal-sidebar-width);
            }

            .portal-container.mobile-active .brand-text,
            .portal-container.mobile-active .user-info,
            .portal-container.mobile-active .sidebar-nav span,
            .portal-container.mobile-active .logout-btn span {
                display: inline;
            }

            .mobile-menu-btn {
                display: block;
            }

            .sidebar-toggle-btn {
                display: none;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const portalContainer = document.getElementById('portalContainer');
            const sidebarCollapseBtn = document.getElementById('sidebarCollapseBtn');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const themeToggleBtn = document.querySelector('[data-theme-toggle]');

            // Collapse Sidebar
            if (sidebarCollapseBtn) {
                sidebarCollapseBtn.addEventListener('click', () => {
                    portalContainer.classList.toggle('collapsed');
                    localStorage.setItem('sidebar-collapsed', portalContainer.classList.contains('collapsed'));
                });

                if (localStorage.getItem('sidebar-collapsed') === 'true') {
                    portalContainer.classList.add('collapsed');
                }
            }

            // Mobile Menu
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    portalContainer.classList.toggle('mobile-active');
                });
            }

            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 992 && portalContainer.classList.contains('mobile-active')) {
                    if (!e.target.closest('#portalSidebar') && !e.target.closest('#mobileMenuBtn')) {
                        portalContainer.classList.remove('mobile-active');
                    }
                }
            });

            // Theme Toggle
            if (themeToggleBtn) {
                const root = document.documentElement;
                themeToggleBtn.addEventListener('click', () => {
                    const newTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
                    root.dataset.theme = newTheme;
                    localStorage.setItem('theme', newTheme);
                });

                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    root.dataset.theme = savedTheme;
                }
            }

            // Auto dismiss toast
            const toast = document.querySelector('.toast');
            if (toast) {
                setTimeout(() => {
                    toast.classList.remove('is-visible');
                }, 4000);
            }
        });
    </script>
</body>
</html>
