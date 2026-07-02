@extends('layouts.cms', ['title' => 'Public Site Pages'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Website Core Pages</h2>
        <button class="btn btn-primary" onclick="alert('Creating new page draft...')"><i class="fa-solid fa-plus"></i> Add New Page</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Page Title</th>
                    <th>Url Slug</th>
                    <th>Status</th>
                    <th>Template</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td><strong>{{ $page->title }}</strong></td>
                        <td><code>/{{ $page->slug }}</code></td>
                        <td>
                            <span class="status-pill {{ $page->is_published ? 'status-paid' : 'status-pending' }}">
                                {{ $page->is_published ? 'PUBLISHED' : 'DRAFT' }}
                            </span>
                        </td>
                        <td><span class="pill">{{ $page->template }}</span></td>
                        <td>
                            <a href="{{ route('cms.builder', ['id' => $page->id]) }}" class="btn btn-soft" style="min-height:32px; font-size:12px;"><i class="fa-solid fa-edit"></i> Edit Blocks</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No pages defined.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $pages->links() }}
    </div>
</div>
@endsection
