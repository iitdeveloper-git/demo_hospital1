@extends('layouts.cms', ['title' => 'Newsletter Subscribers list'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2>Email Newsletter List</h2>
        <div style="display:flex; gap:10px;">
            <button class="btn btn-soft" onclick="alert('Importing CSV list...')"><i class="fa-solid fa-file-import"></i> Import</button>
            <button class="btn btn-soft" onclick="alert('Exporting CSV list...')"><i class="fa-solid fa-file-export"></i> Export</button>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Subscriber Email Address</th>
                    <th>Double Opt-in Status</th>
                    <th>Date Subscribed</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $sub)
                    <tr>
                        <td><strong>{{ $sub->email }}</strong></td>
                        <td>
                            <span class="status-pill {{ $sub->is_verified ? 'status-paid' : 'status-pending' }}">
                                {{ $sub->is_verified ? 'VERIFIED' : 'PENDING' }}
                            </span>
                        </td>
                        <td>{{ $sub->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="empty-state">No newsletter subscribers logged.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $subscribers->links() }}
    </div>
</div>
@endsection
