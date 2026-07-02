@extends('layouts.admin', ['title' => 'Laboratory Module Overview'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Laboratory Command</h2>
        <span class="badge badge-ready">MODULE COMPATIBLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-flask"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Diagnostics & Laboratory Orders</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Manage pathology lab orders, assign technicians, track sample collections, and upload finalized radiology PDFs.</p>
        
        <div style="background-color:var(--bg-primary); border:1px solid var(--border-color); padding: 14px; border-radius: 8px; display:inline-block; text-align: left; min-width: 200px;">
            <span style="font-size:11px; color:var(--text-muted); text-transform:uppercase; font-weight:600; display:block;">Pending Diagnostics</span>
            <strong>18 Lab Orders</strong>
        </div>
    </div>
</div>
@endsection
