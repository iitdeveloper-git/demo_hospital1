@extends('layouts.admin', ['title' => 'Pharmacy Module Overview'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Pharmacy Management Console</h2>
        <span class="badge badge-ready">MODULE COMPATIBLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-prescription-bottle-medical"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">E-Pharmacy & Medication Stocks</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Configure medicine catalogs, track low stock alerts, view expiration limits, and manage prescription sales pipelines.</p>
        
        <div class="quick-status-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; text-align: left; max-width: 600px; margin: 0 auto;">
            <div style="background-color:var(--bg-primary); border:1px solid var(--border-color); padding: 14px; border-radius: 8px;">
                <span style="font-size:11px; color:var(--text-muted); text-transform:uppercase; font-weight:600; display:block;">Total Medicines</span>
                <strong>300 Items</strong>
            </div>
            <div style="background-color:var(--bg-primary); border:1px solid var(--border-color); padding: 14px; border-radius: 8px;">
                <span style="font-size:11px; color:var(--text-muted); text-transform:uppercase; font-weight:600; display:block;">Stock Alerts</span>
                <strong style="color:#ef4444;">12 Items Low</strong>
            </div>
        </div>
    </div>
</div>
@endsection
