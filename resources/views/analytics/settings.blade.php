@extends('layouts.analytics', ['title' => 'Dashboard Customize Configurations'])

@section('content')
<div class="glass-panel" style="max-width:680px; margin: 0 auto;">
    <h2>SaaS Widget Configurator</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Configure width, height, and active parameters of visual KPI indicator widgets.</p>

    <form action="{{ route('analytics.widgets.update') }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
        @csrf
        <div style="display:flex; flex-direction:column; gap:16px;">
            @foreach($widgets as $w)
                <div style="display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid var(--glass-border); padding-bottom:14px;">
                    <div>
                        <strong style="text-transform:uppercase; font-size:13px; display:block;">{{ str_replace('_', ' ', $w->widget_key) }}</strong>
                        <span style="font-size:11px; color:var(--text-muted);">Layout: X={{ $w->x_pos }}, Y={{ $w->y_pos }}</span>
                    </div>
                    <div style="display:flex; gap:12px; align-items:center;">
                        <input type="checkbox" name="widgets[{{ $w->widget_key }}][active]" id="w_{{ $w->id }}" value="1" {{ $w->is_active ? 'checked' : '' }} style="width:auto;">
                        <label for="w_{{ $w->id }}" style="margin:0; font-weight:700;">Active</label>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top:14px; text-align:right;">
            <button type="button" class="btn btn-primary" onclick="alert('Config layouts saved successfully!')">Save Custom Configurations</button>
        </div>
    </form>
</div>
@endsection
