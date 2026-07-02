@extends('layouts.admin', ['title' => 'Inventory Module Overview'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Inventory & Bed Allocation</h2>
        <span class="badge badge-ready">MODULE COMPATIBLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-warehouse"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Inventory Logs & Equipment</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Monitor ICU equipment status, oxygen cylinder reserves, wheelchair counts, hospital bed occupancies, and vendor order pipelines.</p>
    </div>
</div>
@endsection
