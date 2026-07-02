@extends('layouts.er', ['title' => 'Clinical response metrics'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; text-align: center; padding: 40px 20px;">
    <h2>ER Response Metrics Reports</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">View average ambulance response margins, OT utilization timelines, and trauma bay vacancy charts.</p>
    
    <div style="display:flex; flex-direction:column; gap:12px;">
        <button class="btn btn-secondary" onclick="alert('Exporting Ambulance Response CSV...')"><i class="fa-solid fa-file-csv"></i> Download Ambulance Dispatch CSV</button>
        <button class="btn btn-secondary" onclick="alert('Exporting Bed occupancy PDF...')"><i class="fa-solid fa-file-pdf"></i> Download ICU Bed occupancy PDF</button>
    </div>
</div>
@endsection
