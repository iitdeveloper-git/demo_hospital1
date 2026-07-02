@extends('layouts.inventory', ['title' => 'Wards Directory'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Wards Directory</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Ward ID</th>
                    <th>Ward Name</th>
                    <th>Clinical Department</th>
                    <th>Beds Configured</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wards as $ward)
                    <tr>
                        <td>WRD-{{ str_pad((string)$ward->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td><strong>{{ $ward->name }}</strong></td>
                        <td>{{ $ward->department_name }}</td>
                        <td><strong>{{ $ward->beds_count }} Beds Capacity</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No hospital wards registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $wards->links() }}
    </div>
</div>
@endsection
