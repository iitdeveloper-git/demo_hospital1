@extends('layouts.billing', ['title' => 'Settings'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; padding:40px 20px;">
    <h2>Financial ERP Settings</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">Configure GST threshold percentages, corporate discount codes, and currency rules.</p>
    
    <div style="text-align: left; display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Hospital GSTIN</span>
            <strong>29AAAAA1111A1Z1</strong>
        </div>
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Standard Currency Symbol</span>
            <strong>USD ($)</strong>
        </div>
    </div>
</div>
@endsection
