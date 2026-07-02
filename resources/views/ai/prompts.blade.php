@extends('layouts.ai', ['title' => 'AI System Prompt Manager'])

@section('content')
<div class="glass-panel">
    <h2>Prompt Template Architect</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Configure structural prompts used for symptom checker, interactions checker, and patient summary generation.</p>

    <div style="display:flex; flex-direction:column; gap:24px;">
        @foreach($prompts as $pr)
            <div class="glass-panel" style="background:var(--bg-card);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; border-bottom:1px solid var(--glass-border); padding-bottom:10px;">
                    <div>
                        <strong style="font-size:16px;">{{ $pr->name }}</strong>
                        <span style="font-size:11px; color:var(--text-muted); display:block;">Slug: <code>{{ $pr->slug }}</code> | Version: {{ $pr->version }}</span>
                    </div>
                </div>

                <form action="{{ route('ai.prompts.update') }}" method="POST" style="display:flex; flex-direction:column; gap:16px;">
                    @csrf
                    <input type="hidden" name="id" value="{{ $pr->id }}">

                    <div>
                        <label style="font-weight:700;">System Prompt Instructions</label>
                        <textarea name="system_prompt" rows="3" required style="font-family:monospace; font-size:13px;">{{ $pr->system_prompt }}</textarea>
                    </div>

                    <div>
                        <label style="font-weight:700;">User Prompt Template (Dynamic Variables in brackets)</label>
                        <textarea name="user_prompt_template" rows="3" required style="font-family:monospace; font-size:13px;">{{ $pr->user_prompt_template }}</textarea>
                    </div>

                    <div style="text-align:right;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Save Template Architect</button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
