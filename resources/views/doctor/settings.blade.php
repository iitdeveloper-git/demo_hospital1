@extends('layouts.doctor', ['title' => 'Clinical Settings'])

@section('content')
<div class="settings-wrap">
    <div class="panel" style="max-width: 600px; margin: 0 auto;">
        <div class="panel-header">
            <h2>Clinical Profile Settings</h2>
        </div>
        
        <form action="{{ route('doctor.settings.update') }}" method="POST" class="settings-form-doc">
            @csrf
            <input type="hidden" name="profile_update" value="1">
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="consultation_fee">Standard Consultation Fee ($)</label>
                <input type="number" id="consultation_fee" name="consultation_fee" step="0.01" value="{{ old('consultation_fee', $doctor->consultation_fee) }}" required>
            </div>

            <div class="form-group">
                <label for="online_fee">Online Video Consultation Fee ($)</label>
                <input type="number" id="online_fee" name="online_fee" step="0.01" value="{{ old('online_fee', $doctor->online_fee) }}" required>
            </div>

            <div class="form-group">
                <label for="bio">Professional Profile Bio</label>
                <textarea id="bio" name="bio" rows="4">{{ old('bio', $doctor->bio) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top:10px;"><i class="fa-solid fa-save"></i> Save Settings</button>
        </form>
    </div>
</div>

<style>
    .settings-form-doc {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .settings-form-doc .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .settings-form-doc label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
    }

    .settings-form-doc input,
    .settings-form-doc textarea {
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        background: var(--bg-primary);
        color: var(--text-main);
        font-family: inherit;
    }

    .settings-form-doc input:focus,
    .settings-form-doc textarea:focus {
        outline: none;
        border-color: var(--brand-primary);
    }
</style>
@endsection
