@extends('layouts.cms', ['title' => 'Newsroom announcements'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Hospital Press Announcements</h2>
        <button class="btn btn-primary" onclick="alert('Opening news article editor...')"><i class="fa-solid fa-plus"></i> Add News Article</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Article Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Date Published</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $article)
                    <tr>
                        <td><strong>{{ $article->title }}</strong></td>
                        <td><span class="pill">{{ strtoupper($article->category) }}</span></td>
                        <td>
                            <span class="status-pill status-{{ $article->status === 'published' ? 'paid' : 'pending' }}">
                                {{ strtoupper($article->status) }}
                            </span>
                        </td>
                        <td>{{ $article->published_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No news articles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $news->links() }}
    </div>
</div>
@endsection
