@extends('layouts.admin', ['title' => 'Departments Control'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Clinical Departments</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Dept ID</th>
                    <th>Icon</th>
                    <th>Department Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                    <tr>
                        <td>DEPT-{{ str_pad((string)$dept->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><span style="font-size:18px; color:var(--brand-primary);"><i class="fa-solid {{ $dept->icon }}"></i></span></td>
                        <td><strong>{{ $dept->name }}</strong></td>
                        <td><code>/services/{{ $dept->slug }}</code></td>
                        <td><span class="status-pill status-{{ $dept->is_active ? 'active' : 'cancelled' }}">{{ $dept->is_active ? 'Active' : 'Disabled' }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No clinical departments registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $departments->links() }}
    </div>
</div>
@endsection
