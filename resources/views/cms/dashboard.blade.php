@extends('layouts.cms', ['title' => 'CMS & Marketing Dashboard'])

@section('content')
<div class="dashboard-wrap">
    <!-- Stat grid -->
    <div class="stat-grid" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:32px;">
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(20,184,166,0.1); color:#14b8a6;"><i class="fa-solid fa-pager"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">PUBLISHED PAGES</span>
                <strong style="font-size:20px; display:block;">{{ $publishedCount }} Pages</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(14,165,233,0.1); color:#0ea5e9;"><i class="fa-solid fa-square-rss"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">ACTIVE BLOG POSTS</span>
                <strong style="font-size:20px; display:block;">{{ $blogPostsCount }} Articles</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(139,92,246,0.1); color:#8b5cf6;"><i class="fa-solid fa-photo-film"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">MEDIA UPLOADS</span>
                <strong style="font-size:20px; display:block;">{{ $mediaCount }} Files</strong>
            </div>
        </div>
        <div class="glass-panel" style="display:flex; align-items:center; gap:14px; padding:18px;">
            <div style="font-size:24px; padding:10px; border-radius:10px; background:rgba(239,68,68,0.1); color:#ef4444;"><i class="fa-solid fa-bolt"></i></div>
            <div>
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">AGGREGATE SEO SCORE</span>
                <strong style="font-size:20px; display:block;">{{ $seoScore }}/100</strong>
            </div>
        </div>
    </div>

    <!-- Quick stats chart & newsletter subscribers info split -->
    <div style="display:grid; grid-template-columns: 1.2fr 0.8fr; gap:24px; align-items:start;">
        <!-- Left: Visual metrics -->
        <div class="glass-panel" style="min-height:360px;">
            <h2>Public Website Traffic Overview</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Monthly page impressions compiled across pages</p>
            <div style="height:260px; position:relative;">
                <canvas id="cmsTrafficChart"></canvas>
            </div>
        </div>

        <!-- Right: Newsletter subscriber aggregates -->
        <div class="glass-panel" style="display:flex; flex-direction:column; gap:18px;">
            <h2>Opt-In Email Subscribers</h2>
            <p style="color:var(--text-muted); font-size:13px;">Overview of newsletters list subscriptions</p>
            
            <div style="padding:16px; border:1px solid var(--glass-border); border-radius:12px;">
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">SUBSCRIBERS</span>
                <strong style="display:block; font-size:24px; color:#14b8a6; margin-top:4px;">{{ $newsletterCount }}</strong>
            </div>

            <div style="padding:16px; border:1px solid var(--glass-border); border-radius:12px;">
                <span style="font-size:11px; color:var(--text-muted); font-weight:700;">PENDING SUPPORT FORMS</span>
                <strong style="display:block; font-size:24px; color:#f97316; margin-top:4px;">{{ $messagesCount }} Messages</strong>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('cmsTrafficChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Page Views',
                    data: [14200, 18500, 24000, 31000, 29000, 42000],
                    borderColor: '#14b8a6',
                    backgroundColor: 'rgba(20, 184, 166, 0.08)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endsection
