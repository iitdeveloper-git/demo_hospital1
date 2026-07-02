@extends('layouts.inventory', ['title' => 'ERP Settings'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; padding:40px 20px;">
    <h2>Logistics Settings</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">Configure default depreciation rules, barcode scan patterns, and reorder levels thresholds.</p>
    
    <div style="text-align: left; display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Depreciation Standard Method</span>
            <strong>Straight Line Method (10% Annually)</strong>
        </div>
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Central Warehouse Location</span>
            <strong>Basement Wing A, Room B12</strong>
        </div>
    </div>
</div>
@endsection
