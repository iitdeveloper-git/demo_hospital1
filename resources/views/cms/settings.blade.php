@extends('layouts.cms', ['title' => 'Global Branding & Settings'])

@section('content')
<div class="glass-panel" style="max-width:680px; margin:0 auto;">
    <h2>Branding Configurator</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Configure hospital logos, favicons, business hours, and operational contact credentials.</p>

    <form action="{{ route('cms.settings.update') }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
        @csrf
        <div>
            <label for="hospital_logo">Hospital Logo Path</label>
            <input type="text" name="hospital_logo" id="hospital_logo" value="/images/logo.png" required>
        </div>

        <div>
            <label for="favicon">Website Favicon Path</label>
            <input type="text" name="favicon" id="favicon" value="/images/favicon.ico" required>
        </div>

        <div>
            <label for="business_hours">Hospital Working Hours Summary</label>
            <input type="text" name="business_hours" id="business_hours" value="24/7 Emergency, Mon-Sat OPD: 09:00 AM - 08:00 PM" required>
        </div>

        <div style="margin-top:14px; text-align:right;">
            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save Global Branding</button>
        </div>
    </form>
</div>
@endsection
