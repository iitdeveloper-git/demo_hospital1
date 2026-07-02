@extends('layouts.admin', ['title' => 'Gallery Assets Management'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>CMS - Gallery Assets</h2>
        <span class="badge badge-ready">CMS CONSOLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-images"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Media Gallery & Albums</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Upload facility photos, clinic tour videos, organize media albums, and manage featured homepage banners.</p>
    </div>
</div>
@endsection
