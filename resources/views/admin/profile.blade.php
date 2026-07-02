@extends('layouts.admin', ['title' => 'My Admin Profile'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; text-align: center; padding:40px 20px;">
    <div style="width: 80px; height: 80px; border-radius: 50%; background-color: var(--brand-soft); color: var(--brand-primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; font-weight: 700; border: 2px solid var(--border-color);">
        {{ substr(Auth::user()->name, 0, 2) }}
    </div>
    <h2>{{ Auth::user()->name }}</h2>
    <span class="badge badge-ready" style="margin-bottom: 24px;">Administrator Control</span>
    
    <div style="text-align: left; border-top: 1px solid var(--border-color); padding-top: 20px; display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Email Address</span>
            <strong>{{ Auth::user()->email }}</strong>
        </div>
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Contact Phone</span>
            <strong>{{ Auth::user()->phone ?? 'Not Configured' }}</strong>
        </div>
    </div>
</div>
@endsection
