@extends('layouts.hr', ['title' => 'Departments List'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Departments</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>Code Name (Slug)</th>
                    <th>Staff count</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                    <tr>
                        <td>DEPT-{{ str_pad((string)$dept->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $dept->name }}</strong></td>
                        <td><code>{{ $dept->slug }}</code></td>
                        <td><strong>{{ $dept->doctors_count }} clinicians</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No departments registered.</td>
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
