@extends('layouts.inventory', ['title' => 'Logistics Reports'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto; text-align: center; padding: 40px 20px;">
    <h2>Logistics Ledger Reports</h2>
    <p style="color:var(--text-muted); font-size:14px; margin-bottom:24px;">View general stock consumption margins, asset depreciation timelines, and ward vacancy charts.</p>
    
    <div style="display:flex; flex-direction:column; gap:12px;">
        <button class="btn btn-secondary" onclick="alert('Exporting Stock Valuation CSV...')"><i class="fa-solid fa-file-csv"></i> Download Stock Cost Ledger CSV</button>
        <button class="btn btn-secondary" onclick="alert('Exporting Asset Depreciation PDF...')"><i class="fa-solid fa-file-pdf"></i> Download Asset Tags Depreciation PDF</button>
    </div>
</div>
@endsection
