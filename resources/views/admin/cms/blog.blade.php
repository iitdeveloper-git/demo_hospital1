@extends('layouts.admin', ['title' => 'Blog Posts Management'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>CMS - Blog Posts</h2>
        <span class="badge badge-ready">CMS CONSOLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-blog"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Blogs, Articles, and SEO Configuration</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Manage health advice articles, edit categories, configure meta description tags, and publish or draft blog content.</p>
    </div>
</div>
@endsection
