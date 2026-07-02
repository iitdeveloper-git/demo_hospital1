@extends('layouts.admin', ['title' => 'Testimonials Management'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>CMS - Patient Testimonials</h2>
        <span class="badge badge-ready">CMS CONSOLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-quote-left"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Patient Stories & Reviews</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Moderate patient reviews, edit features testimonials, approve submissions, and configure visibility on the main homepage.</p>
    </div>
</div>
@endsection
