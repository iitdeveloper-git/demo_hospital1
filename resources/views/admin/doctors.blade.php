@extends('layouts.admin', ['title' => 'Doctors Registry Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Clinical Specialists</h2>
        <form action="{{ route('admin.doctors') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search specialists..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Emp ID</th>
                    <th>Full Name</th>
                    <th>Clinical Department</th>
                    <th>Specialization</th>
                    <th>Consultation Fee</th>
                    <th>Online Fee</th>
                    <th>Rating</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($doctors as $doc)
                    <tr>
                        <td><strong>{{ $doc->employee_id }}</strong></td>
                        <td><strong>{{ $doc->full_name }}</strong></td>
                        <td>{{ $doc->department->name }}</td>
                        <td>{{ $doc->specialization }}</td>
                        <td>${{ number_format($doc->consultation_fee, 2) }}</td>
                        <td>${{ number_format($doc->online_fee, 2) }}</td>
                        <td><span style="color:#eab308; font-weight:700;"><i class="fa-solid fa-star"></i> {{ $doc->rating }}</span></td>
                        <td><span class="status-pill status-{{ $doc->status }}">{{ ucfirst($doc->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-state">No clinical specialists registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $doctors->links() }}
    </div>
</div>
@endsection
