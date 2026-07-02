@extends('layouts.inventory', ['title' => 'Vendors Directory'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Registered Hospital Suppliers & Vendors</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Vendor Name</th>
                    <th>Contact Person</th>
                    <th>Phone</th>
                    <th>Email Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vendors as $vendor)
                    <tr>
                        <td><strong>{{ $vendor->company_name }}</strong></td>
                        <td>{{ $vendor->contact_person }}</td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-state">No vendors registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $vendors->links() }}
    </div>
</div>
@endsection
