<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory ERP Login | AarogyaCare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        :root {
            --bg-primary: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --brand-primary: #f97316;
            --brand-hover: #ea580c;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .split-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
        }

        .branding-panel {
            background: linear-gradient(135deg, #0f172a 0%, #f97316 100%);
            color: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .branding-panel::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(249, 115, 22, 0.15);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            filter: blur(80px);
        }

        .branding-header .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #ffffff;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 24px;
        }

        .brand-icon {
            color: #fdba74;
            font-size: 24px;
        }

        .branding-body {
            max-width: 480px;
            z-index: 2;
        }

        .branding-body h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -0.02em;
        }

        .branding-body p {
            color: #ffedd5;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .feature-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #fff7ed;
        }

        .feature-item i {
            color: #fdba74;
        }

        .branding-footer {
            font-size: 12px;
            color: #64748b;
        }

        .form-panel {
            background-color: var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
        }

        .form-header h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 8px;
        }

        .form-header p {
            color: var(--text-muted);
            margin: 0 0 32px;
            font-size: 14px;
        }

        .alert {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
            padding: 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .form-group input {
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .forgot-link {
            color: var(--brand-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background-color: var(--brand-primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .submit-btn:hover {
            background-color: var(--brand-hover);
        }

        @media (max-width: 768px) {
            .split-container {
                grid-template-columns: 1fr;
            }
            .branding-panel {
                display: none;
            }
            .form-panel {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Left Branding Panel -->
        <div class="branding-panel">
            <div class="branding-header">
                <a href="/" class="brand-logo">
                    <span class="brand-icon"><i class="fa-solid fa-heart-pulse"></i></span>
                    <span>AarogyaCare</span>
                </a>
            </div>

            <div class="branding-body">
                <h1>Hospital Logistics Console.</h1>
                <p>Welcome to the AarogyaCare & Asset control panel. Securely log in to track consumable levels, check in goods receipts, register new assets, and schedule preventive device calibrations.</p>
                
                <div class="feature-list">
                    <div class="feature-item"><i class="fa-solid fa-circle-check"></i> Real-time ICU bed occupancy tracking</div>
                    <div class="feature-item"><i class="fa-solid fa-circle-check"></i> Multi-warehouse stock transfers registry</div>
                    <div class="feature-item"><i class="fa-solid fa-circle-check"></i> Corrective calibration technician scheduling</div>
                    <div class="feature-item"><i class="fa-solid fa-circle-check"></i> Goods receipt PO dispatch checking</div>
                </div>
            </div>

            <div class="branding-footer">
                &copy; {{ date('Y') }} AarogyaCare All rights reserved.
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Logistics Sign In</h2>
                    <p>Enter your corporate credentials to access the ERP.</p>
                </div>

                @if ($errors->any())
                    <div class="alert">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inventory.login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Staff Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="manager@AarogyaCare.test" autocomplete="email" autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢" autocomplete="current-password">
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" id="remember"> Remember me
                        </label>
                        <a href="#" class="forgot-link" onclick="alert('Password reset link has been dispatched to your corporate email.')">Forgot password?</a>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fa-solid fa-boxes-stacked"></i> Logistics Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
