@extends('layouts.hr', ['title' => 'Annual Performance Reviews'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; text-align: center; padding: 40px 20px;">
    <h2>Employee Annual Performance Reviews</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">View quarterly/annual review sheets, KPIs, and promotion recommendations.</p>
    
    <div style="display:flex; flex-direction:column; gap:12px;">
        <button class="btn btn-secondary" onclick="alert('Exporting Performance reviews CSV...')"><i class="fa-solid fa-file-csv"></i> Download Annual Reviews CSV</button>
    </div>
</div>
@endsection
