@extends('layouts.billing', ['title' => 'Generate Outpatient Invoice'])

@section('content')
<div class="panel" style="max-width: 600px; margin: 0 auto;">
    <div class="panel-header">
        <h2>Generate Outpatient Bill</h2>
    </div>

    <form action="{{ route('billing.create') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
        @csrf

        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="patient_id" style="font-size:13px; font-weight:600; color:var(--text-muted);">Outpatient Customer</label>
            <select id="patient_id" name="patient_id" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
                <option value="">Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->user->name }} ({{ $patient->patient_code }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="item_name" style="font-size:13px; font-weight:600; color:var(--text-muted);">Consultation / Procedure Description</label>
            <input type="text" id="item_name" name="item_name" placeholder="E.g. General Practice Consultation" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
        </div>

        <div class="form-group" style="display:flex; flex-direction:column; gap:6px;">
            <label for="price" style="font-size:13px; font-weight:600; color:var(--text-muted);">Unit Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" required style="padding:10px 12px; border:1px solid var(--border-color); border-radius:8px; background-color:var(--bg-primary); color:var(--text-main); font-family:inherit; font-size:13.5px;">
        </div>

        <button type="submit" class="btn btn-primary" style="justify-content:center;"><i class="fa-solid fa-file-invoice-dollar"></i> Generate GST Invoice</button>
    </form>
</div>
@endsection
