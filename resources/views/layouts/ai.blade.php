<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Clinical AI Co-Pilot' }} | AarogyaCare</title>
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
            --brand-gradient: linear-gradient(135deg, #0f6fff, #14b8a6);
        }

        [data-theme="dark"] {
            --glass-bg: rgba(13, 27, 46, 0.7);
            --glass-border: rgba(255, 255, 255, 0.08);
            --glass-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at 10% 20%, rgba(15, 111, 255, 0.03) 0%, rgba(20, 184, 166, 0.02) 90%);
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

        .disclaimer-banner {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.12), rgba(245, 158, 11, 0.12));
            border-left: 5px solid #ef4444;
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13.5px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .disclaimer-banner i {
            font-size: 20px;
            color: #ef4444;
        }

        .ai-sidebar {
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
        <aside class="sidebar ai-sidebar">
            <a class="brand" href="/">
                <span class="brand-mark"><i class="fa-solid fa-microchip-ai"></i></span>
                <span>Medova AI</span>
            </a>
            
            <nav aria-label="AI Navigation">
                <a href="{{ route('ai.dashboard') }}" class="{{ Route::currentRouteName() === 'ai.dashboard' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i><span>AI Dashboard</span>
                </a>
                <a href="{{ route('ai.chat') }}" class="{{ Route::currentRouteName() === 'ai.chat' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-comments"></i><span>Clinical Chat</span>
                </a>
                <a href="{{ route('ai.patient-summary') }}" class="{{ Route::currentRouteName() === 'ai.patient-summary' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-user-clock"></i><span>Patient Timeline</span>
                </a>
                <a href="{{ route('ai.symptom-checker') }}" class="{{ Route::currentRouteName() === 'ai.symptom-checker' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-stethoscope"></i><span>Symptom Triage</span>
                </a>
                <a href="{{ route('ai.lab-insights') }}" class="{{ Route::currentRouteName() === 'ai.lab-insights' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-flask-vial"></i><span>Lab Insights</span>
                </a>
                <a href="{{ route('ai.radiology-insights') }}" class="{{ Route::currentRouteName() === 'ai.radiology-insights' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-x-ray"></i><span>Radiology</span>
                </a>
                <a href="{{ route('ai.prescription-review') }}" class="{{ Route::currentRouteName() === 'ai.prescription-review' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-file-medical"></i><span>Prescriptions</span>
                </a>
                <a href="{{ route('ai.drug-interactions') }}" class="{{ Route::currentRouteName() === 'ai.drug-interactions' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-capsules"></i><span>Drug Interactions</span>
                </a>
                <a href="{{ route('ai.risk-score') }}" class="{{ Route::currentRouteName() === 'ai.risk-score' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-heart-pulse"></i><span>Risk Gauges</span>
                </a>
                <a href="{{ route('ai.alerts') }}" class="{{ Route::currentRouteName() === 'ai.alerts' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-bell-exclamation"></i><span>Alerts Desk</span>
                </a>
                <a href="{{ route('ai.settings') }}" class="{{ Route::currentRouteName() === 'ai.settings' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-sliders"></i><span>Engine Settings</span>
                </a>
                <a href="{{ route('ai.prompts') }}" class="{{ Route::currentRouteName() === 'ai.prompts' ? 'nav-item-active' : '' }}">
                    <i class="fa-solid fa-terminal"></i><span>Prompt Manager</span>
                </a>
            </nav>
        </aside>

        <!-- Main Body -->
        <main class="dashboard-main">
            <!-- Topbar -->
            <header class="dashboard-topbar">
                <div>
                    <h1>{{ $title ?? 'Clinical AI Co-Pilot' }}</h1>
                    <p style="color:var(--text-muted); font-size: 13.5px; margin: 4px 0 0;">Enterprise-Grade Clinical Decision Support System</p>
                </div>
                <div class="header-actions">
                    <button class="icon-button" onclick="toggleTheme()" aria-label="Toggle dark mode"><i class="fa-solid fa-moon"></i></button>
                    
                    @auth
                        <div class="user-profile-badge" style="display:flex; align-items:center; gap:10px;">
                            <span style="font-size:12px; font-weight:700;">{{ Auth::user()->name }}</span>
                            <span class="pill" style="text-transform:uppercase; font-size:10px;">{{ Auth::user()->role->name }}</span>
                            <form action="{{ route('doctor.logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="icon-button" style="color:var(--danger); background:transparent; min-height:auto;" aria-label="Sign out"><i class="fa-solid fa-sign-out-alt"></i></button>
                            </form>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Global Disclaimer -->
            <div class="disclaimer-banner">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <strong>Clinical Advisor Decision Support (CDSS):</strong> AI outputs are advisory only. Final medical decisions must be verified independently by licensed health practitioners.
                </div>
            </div>

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
