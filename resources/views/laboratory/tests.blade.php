@extends('layouts.laboratory', ['title' => 'Test Master Catalog'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Diagnostics Test Master Catalog</h2>
        <form action="{{ route('laboratory.tests') }}" method="GET" class="search-form">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search test name or code..." style="padding: 8px 12px; border:1px solid var(--border-color); border-radius:6px; background:var(--bg-primary); color:var(--text-main);">
            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-wrap">
        <table class="portal-table">
            <thead>
                <tr>
                    <th>Test Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Reference Range</th>
                    <th>Units</th>
                    <th>Fee ($)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tests as $test)
                    <tr>
                        <td><code>{{ $test->test_code }}</code></td>
                        <td><strong>{{ $test->name }}</strong></td>
                        <td>{{ $test->category->name }}</td>
                        <td><code style="background-color:var(--bg-primary); padding:2px 6px; border-radius:4px;">{{ $test->normal_range }}</code></td>
                        <td>{{ $test->units }}</td>
                        <td><strong>${{ number_format($test->price, 2) }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-state">No LIMS tests registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-container" style="margin-top:24px; display:flex; justify-content:flex-end;">
        {{ $tests->links() }}
    </div>
</div>
@endsection
