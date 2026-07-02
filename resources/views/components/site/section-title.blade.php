@props(['eyebrow', 'title', 'description' => null, 'align' => 'left'])

<div {{ $attributes->merge(['class' => 'section-heading section-heading--'.$align]) }}>
    <span class="eyebrow">{{ $eyebrow }}</span>
    <h2>{{ $title }}</h2>
    @if($description)
        <p>{{ $description }}</p>
    @endif
</div>
