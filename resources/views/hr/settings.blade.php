@extends('layouts.hr', ['title' => 'Shift Calendar Settings'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; padding:40px 20px;">
    <h2>HRMS Configurations</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">Configure rotational shift calendar offsets, leave balances entitlements, and tax slabs rules.</p>
    
    <div style="text-align: left; display: flex; flex-direction: column; gap: 16px; font-size: 14px;">
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Shift Overtime Calculation Offset</span>
            <strong>1.5x Hourly Rate</strong>
        </div>
        <div>
            <span style="color:var(--text-muted); display:block; font-size:11px; text-transform:uppercase; font-weight:600;">Standard Casual Leave Allotment</span>
            <strong>15 Days Annually</strong>
        </div>
    </div>
</div>
@endsection
