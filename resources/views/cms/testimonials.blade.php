@extends('layouts.cms', ['title' => 'Patient Testimonials Management'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Patient Testimonials</h2>
        <button class="btn btn-primary" onclick="alert('Add testimonial form...')"><i class="fa-solid fa-plus"></i> Add Testimonial</button>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Role</th>
                    <th>Rating</th>
                    <th>Attending Feedback Quote</th>
                </tr>
            </thead>
            <tbody>
                @forelse($testimonials as $t)
                    <tr>
                        <td><strong>{{ $t->name }}</strong></td>
                        <td><span class="pill">{{ $t->role }}</span></td>
                        <td style="color:#f59e0b;">
                            @for($i=1; $i<=$t->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </td>
                        <td><p style="margin:0; font-size:13px; max-width:480px;">{{ $t->content }}</p></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No patient testimonials loaded.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $testimonials->links() }}
    </div>
</div>
@endsection
