@extends('layouts.admin', ['title' => 'Employee Module Overview'])

@section('content')
<div class="panel">
    <div class="panel-header">
        <h2>Hospital Employees Directory</h2>
        <span class="badge badge-ready">MODULE COMPATIBLE</span>
    </div>
    
    <div class="module-placeholder-body" style="text-align: center; padding: 40px 20px;">
        <span style="font-size: 48px; color: var(--brand-primary);"><i class="fa-solid fa-people-carry-box"></i></span>
        <h3 style="margin-top:20px; font-size:18px;">Staff & HR Attendance Records</h3>
        <p style="color:var(--text-muted); font-size:14px; max-width: 480px; margin: 10px auto 24px;">Manage administrative staff profiles, nurse schedules, receptionist rosters, lab technician logs, and pharmacist directories.</p>
    </div>
</div>
@endsection
