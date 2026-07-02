@extends('layouts.admin', ['title' => 'User Role Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>System Users</h2>
        <form action="{{ route('admin.users') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>MC-{{ str_pad((string)$user->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td><span class="badge badge-ready">{{ $user->role?->name ?? 'Guest' }}</span></td>
                        <td><span class="status-pill status-{{ $user->status }}">{{ ucfirst($user->status) }}</span></td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No users registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $users->links() }}
    </div>
</div>
@endsection
