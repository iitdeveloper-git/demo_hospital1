@extends('layouts.admin', ['title' => 'Billing & GST Module Overview'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Billing & GST Accounts</h2>
        <span class="badge badge-ready">MODULE COMPATIBLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-file-invoice-dollar"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Invoice Audit Trails & GST Reports</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Configure GST rates, track patient invoice transactions, process billing refunds, and generate monthly revenue worksheets.</p>
    </div>
</div>
@endsection
