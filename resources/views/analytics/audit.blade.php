@extends('layouts.analytics', ['title' => 'ERP Security Audit Desk'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2>Granular Audit Logs</h2>
        
        <!-- Filters Form -->
        <form action="{{ route('analytics.audit') }}" method="GET" style="display:flex; gap:12px; align-items:center;">
            <select name="module" onchange="this.form.submit()">
                <option value="">All Modules</option>
                <option value="patients" {{ $module === 'patients' ? 'selected' : '' }}>Patients Registry</option>
                <option value="doctors" {{ $module === 'doctors' ? 'selected' : '' }}>Doctors Registry</option>
                <option value="billing" {{ $module === 'billing' ? 'selected' : '' }}>Billing & Invoices</option>
                <option value="inventory" {{ $module === 'inventory' ? 'selected' : '' }}>Inventory Items</option>
            </select>

            <select name="action" onchange="this.form.submit()">
                <option value="">All Actions</option>
                <option value="login" {{ $action === 'login' ? 'selected' : '' }}>Login Attempts</option>
                <option value="create" {{ $action === 'create' ? 'selected' : '' }}>Create Entries</option>
                <option value="update" {{ $action === 'update' ? 'selected' : '' }}>Update Entries</option>
                <option value="delete" {{ $action === 'delete' ? 'selected' : '' }}>Delete Entries</option>
                <option value="finance" {{ $action === 'finance' ? 'selected' : '' }}>Financial Mutations</option>
            </select>
        </form>
    </div>

    <!-- Audits Log Grid -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Module</th>
                    <th>IP / Browser Info</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $ev)
                    <tr>
                        <td>
                            <strong>{{ $ev->user->name ?? 'System / Daemon' }}</strong>
                            <span style="display:block; font-size:10px; color:var(--text-muted);">{{ $ev->user->role->name ?? 'Super Admin' }}</span>
                        </td>
                        <td>
                            <span class="status-pill {{ $ev->action === 'delete' ? 'status-cancelled' : ($ev->action === 'finance' ? 'status-paid' : 'status-pending') }}" style="font-weight:700; text-transform:uppercase;">
                                {{ $ev->action }}
                            </span>
                        </td>
                        <td><code>{{ $ev->affected_module }}</code></td>
                        <td>
                            <strong style="display:block; font-size:12px;">{{ $ev->ip_address }}</strong>
                            <small style="color:var(--text-muted); font-size:10px; max-width:260px; overflow:hidden; text-overflow:ellipsis; display:block; white-space:nowrap;">{{ $ev->browser }}</small>
                        </td>
                        <td>{{ $ev->created_at->toDateTimeString() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No audit logs retrieved.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $events->links() }}
    </div>
</div>
@endsection
