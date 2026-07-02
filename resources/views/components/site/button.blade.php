@props(['href' => '#', 'variant' => 'primary', 'icon' => null])

<a {{ $attributes->merge(['class' => 'btn btn-'.$variant.' ripple', 'href' => $href]) }}>
    @if($icon)
        <i class="fa-solid {{ $icon }}"></i>
    @endif
    {{ $slot }}
</a>
