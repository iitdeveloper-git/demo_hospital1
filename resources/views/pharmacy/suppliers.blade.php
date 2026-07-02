@extends('layouts.pharmacy', ['title' => 'Suppliers Registry'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Registered Supplier Accounts</h2>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Supplier Code</th>
                    <th>Company Name</th>
                    <th>GST Number</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Outstanding Balance</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $sup)
                    <tr>
                        <td><strong>{{ $sup->supplier_code }}</strong></td>
                        <td><strong>{{ $sup->company_name }}</strong></td>
                        <td>{{ $sup->gst_number }}</td>
                        <td>{{ $sup->phone }}</td>
                        <td>{{ $sup->email }}</td>
                        <td><strong style="color:#ef4444;">${{ number_format($sup->outstanding_balance, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No suppliers registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $suppliers->links() }}
    </div>
</div>
@endsection
