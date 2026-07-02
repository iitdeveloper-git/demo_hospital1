@extends('layouts.patient', ['title' => 'Account Settings'])

@section('content')
<div class="settings-container-inner">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-triangle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-grid">
        <!-- 1. Profile Settings Card -->
        <div class="panel">
            <div class="panel-header">
                <h2><i class="fa-solid fa-user-gear"></i> Profile Information</h2>
            </div>
            <form action="{{ route('patient.settings.update') }}" method="POST" class="settings-form">
                @csrf
                <input type="hidden" name="profile_update" value="1">
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}" required>
                </div>

                <div class="form-group">
                    <label for="emergency_contact">Emergency Contact</label>
                    <input type="tel" id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" required>
                </div>

                <div class="form-group">
                    <label for="insurance_provider">Insurance Provider</label>
                    <input type="text" id="insurance_provider" name="insurance_provider" value="{{ old('insurance_provider', $patient->insurance_provider) }}">
                </div>

                <button type="submit" class="btn btn-primary btn-save">Save Changes</button>
            </form>
        </div>

        <!-- 2. Password Update Card -->
        <div class="panel">
            <div class="panel-header">
                <h2><i class="fa-solid fa-key"></i> Update Password</h2>
            </div>
            <form action="{{ route('patient.settings.update') }}" method="POST" class="settings-form">
                @csrf
                <input type="hidden" name="password_update" value="1">

                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                </div>

                <button type="submit" class="btn btn-primary btn-save">Update Password</button>
            </form>
        </div>

        <!-- 3. Two-Factor Authentication (Ready) -->
        <div class="panel full-width-panel">
            <div class="panel-header">
                <h2><i class="fa-solid fa-shield-halved"></i> Two-Factor Authentication (2FA)</h2>
                <span class="badge badge-ready">READY</span>
            </div>
            <div class="tfa-body">
                <div class="tfa-info">
                    <p>Enhance the security of your medical records by enabling Two-Factor Authentication. A one-time security code will be requested on login.</p>
                </div>
                <form action="{{ route('patient.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tfa_update" value="1">
                    <div class="tfa-toggle-row">
                        <span class="tfa-status-label">Status: <strong>Disabled</strong></span>
                        <button type="submit" class="btn btn-soft btn-sm">Enable Two-Factor Authentication</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 32px;
    }

    .full-width-panel {
        grid-column: span 2;
    }

    .settings-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 10px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }

    .form-group input {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        background: var(--bg-primary);
        color: var(--text-main);
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .btn-save {
        align-self: flex-start;
        padding: 10px 20px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .badge-ready {
        background-color: rgba(37, 99, 235, 0.15);
        color: var(--brand-primary);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 99px;
    }

    .tfa-body {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 20px;
        margin-top: 10px;
    }

    .tfa-info p {
        margin: 0 0 16px;
        font-size: 13.5px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .tfa-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tfa-status-label {
        font-size: 14px;
    }

    @media (max-width: 992px) {
        .settings-grid {
            grid-template-columns: 1fr;
        }
        .full-width-panel {
            grid-column: auto;
        }
    }
</style>
@endsection
