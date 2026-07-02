@extends('layouts.cms', ['title' => 'Visual Page Builder'])

@section('content')
<div class="glass-panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <div>
            <h2>Block Configurator: {{ $page->title }}</h2>
            <small style="color:var(--text-muted);">Route Target: <code>/{{ $page->slug }}</code></small>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="/{{ $page->slug }}" target="_blank" class="btn btn-soft"><i class="fa-solid fa-eye"></i> Live Preview</a>
            <button class="btn btn-primary" onclick="alert('Block configurations and sorting saved successfully!')"><i class="fa-solid fa-save"></i> Save Page layout</button>
        </div>
    </div>

    <!-- Page Builder grid -->
    <div style="display:grid; grid-template-columns: 0.8fr 1.2fr; gap:32px; align-items:start;">
        <!-- Left: Tool blocks -->
        <div class="glass-panel">
            <h3>Reusable Library Blocks</h3>
            <p style="color:var(--text-muted); font-size:12px; margin-bottom:16px;">Add components to the active page structure.</p>

            <div style="display:flex; flex-direction:column; gap:12px;">
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-rectangle-ad"></i> Hero Banner Slider</div>
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-hospital-user"></i> Department Cards Grid</div>
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-user-doctor"></i> Doctor Profile Slider</div>
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-quote-left"></i> Testimonial Carousel</div>
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-question-circle"></i> FAQ Accordions</div>
                <div class="glass-panel" style="padding:12px; background:var(--bg-card); cursor:pointer;"><i class="fa-solid fa-map-location-dot"></i> Google Map Block</div>
            </div>
        </div>

        <!-- Right: Active Blocks stack -->
        <div class="glass-panel" style="min-height:480px; background:var(--bg-canvas);">
            <h3>Active Page Layout Stack</h3>
            <p style="color:var(--text-muted); font-size:12px; margin-bottom:20px;">Reorder active blocks by dragging.</p>

            <div style="display:flex; flex-direction:column; gap:16px;" id="blocks-stack">
                @foreach($page->sections as $sec)
                    <div class="glass-panel" style="background:var(--bg-card); border-color:#14b8a6; padding:18px; position:relative; cursor:move;">
                        <span style="position:absolute; right:20px; top:20px; color:#14b8a6; font-size:12px; font-weight:700;"><i class="fa-solid fa-grip-vertical"></i> Drag</span>
                        <strong style="text-transform:uppercase; font-size:13px; color:var(--text-muted); display:block; margin-bottom:10px;">{{ str_replace('_', ' ', $sec->section_type) }}</strong>
                        
                        @foreach($sec->blocks as $block)
                            <div style="font-size:14px; font-weight:700; color:#0b2454; margin-top:8px;">
                                {!! json_encode($block->content_json) !!}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        gsap.from("#blocks-stack .glass-panel", {
            duration: 0.5,
            opacity: 0,
            y: 20,
            stagger: 0.1
        });
    });
</script>
@endsection
