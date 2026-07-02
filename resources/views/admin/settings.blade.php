@extends('layouts.admin', ['title' => 'System Configurations'])

@section('content')
<div class="settings-wrap" style="max-width: 600px; margin:0 auto;">
    <div class="panel">
        <div class="panel-header">
            <h2>Hospital System Configurations</h2>
        </div>
        
        <form action="{{ route('admin.settings.update') }}" method="POST" class="settings-form-admin">
            @csrf
            
            <div class="form-group">
                <label for="hospital_name">Hospital Name</label>
                <input type="text" id="hospital_name" name="hospital_name" value="{{ $settings['hospital_name'] ?? 'AarogyaCare' }}" required>
            </div>

            <div class="form-group">
                <label for="contact_email">Corporate Contact Email</label>
                <input type="email" id="contact_email" name="contact_email" value="{{ $settings['contact_email'] ?? 'contact@AarogyaCare.test' }}" required>
            </div>

            <div class="form-group">
                <label for="smtp_host">SMTP Host</label>
                <input type="text" id="smtp_host" name="smtp_host" value="{{ $settings['smtp_host'] ?? 'smtp.mailtrap.io' }}">
            </div>

            <div class="form-group">
                <label for="sms_gateway">SMS Gateway Provider</label>
                <input type="text" id="sms_gateway" name="sms_gateway" value="{{ $settings['sms_gateway'] ?? 'Twilio API' }}">
            </div>

            <div class="form-group">
                <label for="maintenance_mode">Maintenance Mode Status</label>
                <select id="maintenance_mode" name="maintenance_mode">
                    <option value="0" {{ ($settings['maintenance_mode'] ?? '0') === '0' ? 'selected' : '' }}>Disabled</option>
                    <option value="1" {{ ($settings['maintenance_mode'] ?? '0') === '1' ? 'selected' : '' }}>Enabled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:10px;"><i class="fa-solid fa-save"></i> Save Configurations</button>
        </form>
    </div>
</div>

<style>
    .settings-form-admin {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .settings-form-admin .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .settings-form-admin label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .settings-form-admin input,
    .settings-form-admin select {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        background: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
    }

    .settings-form-admin input:focus,
    .settings-form-admin select:focus {
        outline: none;
        border-color: var(--brand-primary);
    }
</style>
@endsection
