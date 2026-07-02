@extends('layouts.hr', ['title' => 'Designations Hierarchy'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Designations Directory</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Designation ID</th>
                    <th>Role Designation Name</th>
                    <th>Salary Grade Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse($designations as $desg)
                    <tr>
                        <td>DESG-{{ str_pad((string)$desg->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $desg->name }}</strong></td>
                        <td><code style="background-color:var(--bg-primary); padding:2px 6px; border-radius:4px;">{{ $desg->salary_grade ?? 'Grade I' }}</code></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">No designations registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $designations->links() }}
    </div>
</div>
@endsection
