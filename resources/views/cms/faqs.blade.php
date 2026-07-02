@extends('layouts.cms', ['title' => 'FAQ Manager'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Frequently Asked Questions</h2>
        <button class="btn btn-primary" onclick="alert('Open FAQ form...')"><i class="fa-solid fa-plus"></i> Add FAQ</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Category</th>
                    <th>Answer Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $faq)
                    <tr>
                        <td><strong>{{ $faq->question }}</strong></td>
                        <td><span class="pill">{{ strtoupper($faq->category) }}</span></td>
                        <td><p style="margin:0; font-size:13px; max-width:540px;">{{ $faq->answer }}</p></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">No FAQs configured.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $faqs->links() }}
    </div>
</div>
@endsection
