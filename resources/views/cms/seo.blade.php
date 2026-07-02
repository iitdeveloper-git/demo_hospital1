@extends('layouts.cms', ['title' => 'SEO Redirection Rules'])

@section('content')
<div class="glass-panel">
    <div style="display:grid; grid-template-columns: 0.9fr 1.1fr; gap:32px; align-items:start;">
        <!-- Left: Form to Add new redirect rule -->
        <div>
            <h2>Register Redirect Rule (301)</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Automatically redirect decommissioned page paths to active ones.</p>

            <form action="{{ route('cms.seo.redirect') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <div>
                    <label for="old_slug">Old Slug Path</label>
                    <input type="text" name="old_slug" id="old_slug" placeholder="E.g. old-cardiology-page" required>
                </div>

                <div>
                    <label for="new_slug">Target Redirect Slug</label>
                    <input type="text" name="new_slug" id="new_slug" placeholder="E.g. cardiology" required>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fa-solid fa-link"></i> Save Redirect Rule</button>
                </div>
            </form>
        </div>

        <!-- Right: Active redirects list -->
        <div style="border-left:1px solid var(--glass-border); padding-left:32px; min-height:360px;">
            <h2>Attending Redirections Registry</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Public SEO sitemaps updates & redirection lists.</p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Old Path</th>
                            <th>Target Path</th>
                            <th>Status Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($redirects as $red)
                            <tr>
                                <td><code>/{{ $red->old_slug }}</code></td>
                                <td><code>/{{ $red->new_slug }}</code></td>
                                <td><span class="pill" style="font-weight:700;">{{ $red->status_code }} Permanent</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-state">No redirect rules recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
