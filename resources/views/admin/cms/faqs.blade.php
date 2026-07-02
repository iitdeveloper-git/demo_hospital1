@extends('layouts.admin', ['title' => 'FAQ Management'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>CMS - Frequently Asked Questions</h2>
        <span class="badge badge-ready">CMS CONSOLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-question-circle"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">FAQs Directory & Categories</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Configure public help topics, add questions and answers, manage display order, and toggle visibility on the patient onboarding panels.</p>
    </div>
</div>
@endsection
