@props(['icon', 'title', 'description', 'href' => '#'])

<a {{ $attributes->merge(['class' => 'icon-service-card hover-lift', 'href' => $href]) }}>
    <span><i class="fa-solid {{ $icon }}"></i></span>
    <strong>{{ $title }}</strong>
    <small>{{ $description }}</small>
</a>
