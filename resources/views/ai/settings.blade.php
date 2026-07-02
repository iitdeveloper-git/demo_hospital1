@extends('layouts.ai', ['title' => 'AI Provider Configurations'])

@section('content')
<div class="glass-panel">
    <h2>LLM Provider Registries</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Configure model targets, API params, fallback failovers, and rate throttling.</p>

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:24px;">
        @foreach($settings as $set)
            <div class="glass-panel" style="background:var(--bg-card); position:relative; border-color:{{ $set->is_active ? '#0f6fff' : 'var(--glass-border)' }};">
                @if($set->is_active)
                    <span class="pill" style="position:absolute; right:20px; top:20px; background:rgba(15,111,255,0.1); color:#0f6fff; font-weight:700;">ACTIVE ENGINE</span>
                @endif
                <h3 style="text-transform:uppercase; margin-bottom:12px;">{{ $set->provider }}</h3>

                <form action="{{ route('ai.settings.update') }}" method="POST" style="display:flex; flex-direction:column; gap:12px;">
                    @csrf
                    <input type="hidden" name="provider" value="{{ $set->provider }}">

                    <div>
                        <label style="font-size:11px; font-weight:700;">Target Model</label>
                        <input type="text" name="model" value="{{ $set->model }}" required>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div>
                            <label style="font-size:11px; font-weight:700;">Temperature</label>
                            <input type="number" step="0.1" name="temperature" value="{{ $set->temperature }}" required>
                        </div>
                        <div>
                            <label style="font-size:11px; font-weight:700;">Token Limit</label>
                            <input type="number" name="token_limit" value="{{ $set->token_limit }}" required>
                        </div>
                    </div>

                    <div>
                        <label style="font-size:11px; font-weight:700;">Active System prompt</label>
                        <textarea name="system_prompt" rows="3" style="font-size:12px;">{{ $set->system_prompt }}</textarea>
                    </div>

                    <div style="display:flex; align-items:center; gap:8px; margin-top:6px;">
                        <input type="checkbox" name="is_active" id="act_{{ $set->provider }}" value="1" {{ $set->is_active ? 'checked' : '' }} style="width:auto;">
                        <label for="act_{{ $set->provider }}" style="margin:0; font-weight:700;">Set as Active Provider</label>
                    </div>

                    <div style="margin-top:10px;">
                        <button type="submit" class="btn btn-primary" style="width:100%; min-height:36px; font-size:12px;">Save Configurations</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
