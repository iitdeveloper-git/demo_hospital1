<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Secure Patient Registration | AarogyaCare</title>
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
            --brand-primary: #2563eb;
            --brand-hover: #1d4ed8;
            --brand-soft: rgba(37, 99, 235, 0.08);
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
            grid-template-columns: 0.8fr 1.2fr;
            width: 100%;
        }

        /* Left Branding Panel */
        .branding-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
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
            background: rgba(37, 99, 235, 0.15);
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
            color: #38bdf8;
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
            color: #93c5fd;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .branding-footer {
            font-size: 12px;
            color: #64748b;
        }

        /* Right Form Panel */
        .form-panel {
            background-color: var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 64px;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
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

        .alert ul {
            margin: 0;
            padding-left: 20px;
            list-style: none;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }

        .form-group label .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select {
            padding: 12px 14px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            background: #ffffff;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
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
            grid-column: span 2;
        }

        .submit-btn:hover {
            background-color: var(--brand-hover);
        }

        .login-prompt {
            text-align: center;
            margin-top: 32px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .login-prompt a {
            color: var(--brand-primary);
            text-decoration: none;
            font-weight: 600;
        }

        .login-prompt a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .split-container {
                grid-template-columns: 1fr;
            }
            .branding-panel {
                display: none;
            }
            .form-panel {
                padding: 24px;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: auto;
            }
            .submit-btn {
                grid-column: auto;
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
                <h1>Join AarogyaCare today.</h1>
                <p>Register as a patient to securely manage appointments, digital medical records, clinical prescriptions, invoices, and active healthcare packages.</p>
            </div>

            <div class="branding-footer">
                &copy; {{ date('Y') }} AarogyaCare All rights reserved.
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="form-panel">
            <div class="form-container">
                <div class="form-header">
                    <h2>Patient Registration</h2>
                    <p>Create a secure patient account to access the command portal.</p>
                </div>

                @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('patient.register') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Jane Doe">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="jane@example.com">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="+91 98765 43210">
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth <span class="required">*</span></label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required max="{{ date('Y-m-d', strtotime('-1 day')) }}">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender <span class="required">*</span></label>
                            <select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="non-binary" {{ old('gender') === 'non-binary' ? 'selected' : '' }}>Non-binary</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="blood_group">Blood Group</label>
                            <select id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bg)
                                    <option value="{{ $bg }}" {{ old('blood_group') === $bg ? 'selected' : '' }}>{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="emergency_contact">Emergency Contact Phone <span class="required">*</span></label>
                            <input type="tel" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact') }}" required placeholder="+91 90000 00000">
                        </div>

                        <div class="form-group">
                            <label for="insurance_provider">Insurance Provider</label>
                            <input type="text" id="insurance_provider" name="insurance_provider" value="{{ old('insurance_provider') }}" placeholder="e.g. CareShield">
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" required placeholder="Minimum 8 characters" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="Re-enter password">
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fa-solid fa-user-plus"></i> Register Secure Account
                        </button>
                    </div>
                </form>

                <div class="login-prompt">
                    Already registered? <a href="{{ route('patient.login') }}">Sign In Here</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
