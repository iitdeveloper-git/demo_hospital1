@extends('layouts.analytics', ['title' => 'Scheduled Reports Dispatch'])

@section('content')
<div class="glass-panel">
    <div style="display:grid; grid-template-columns: 0.9fr 1.1fr; gap:32px; align-items:start;">
        <!-- Left: Form to Add new schedule -->
        <div>
            <h2>Register Email Report Delivery</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Configure automated PDF/CSV summary reports dispatched to executive inbox queues.</p>

            <form action="{{ route('analytics.reports.schedule') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                @csrf
                <div>
                    <label for="name">Report Schedule Name</label>
                    <input type="text" name="name" id="name" placeholder="E.g. Monthly CFO Profit Audit" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div>
                        <label for="report_type">Report Type</label>
                        <select name="report_type" id="report_type" required>
                            <option value="revenue">Financial Revenue</option>
                            <option value="patient">Patient growth</option>
                            <option value="clinical">Clinical KPI alerts</option>
                        </select>
                    </div>
                    <div>
                        <label for="frequency">Frequency</label>
                        <select name="frequency" id="frequency" required>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly" selected>Monthly</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="recipient_email">Executive Recipient Email</label>
                    <input type="email" name="recipient_email" id="recipient_email" placeholder="cfo@aarogyacare.test" required>
                </div>

                <div style="margin-top:8px;">
                    <button type="submit" class="btn btn-primary" style="width:100%;"><i class="fa-solid fa-clock"></i> Register Dispatch Schedule</button>
                </div>
            </form>
        </div>

        <!-- Right: Active Schedules list -->
        <div style="border-left:1px solid var(--glass-border); padding-left:32px; min-height:360px;">
            <h2>Attending Schedules Registry</h2>
            <p style="color:var(--text-muted); font-size:13px; margin-bottom:20px;">Queue-based daemon logs compiled below.</p>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Schedule Name</th>
                            <th>Frequency</th>
                            <th>Recipient</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $sch)
                            <tr>
                                <td>
                                    <strong>{{ $sch->name }}</strong>
                                    <span style="display:block; font-size:10px; color:var(--text-muted);">Type: {{ ucfirst($sch->report_type) }}</span>
                                </td>
                                <td><span class="pill" style="text-transform:uppercase; font-size:9px;">{{ $sch->frequency }}</span></td>
                                <td><span style="font-size:12px;">{{ $sch->recipient_email }}</span></td>
                                <td>
                                    <span class="status-pill status-paid">ACTIVE</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="empty-state">No scheduled dispatches configured.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
