@extends('layouts.cms', ['title' => 'Blog System'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Hospital Wellness Blog</h2>
        <button class="btn btn-primary" onclick="alert('Opening rich-text blog post editor...')"><i class="fa-solid fa-plus"></i> Write Post</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Article Title</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td><strong>{{ $post->title }}</strong></td>
                        <td><span class="pill">{{ $post->category->name ?? 'Uncategorized' }}</span></td>
                        <td>{{ $post->author->name ?? 'System Writer' }}</td>
                        <td>
                            <span class="status-pill status-{{ $post->status === 'published' ? 'paid' : 'pending' }}">
                                {{ strtoupper($post->status) }}
                            </span>
                        </td>
                        <td>{{ $post->published_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No blog posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $posts->links() }}
    </div>
</div>
@endsection
