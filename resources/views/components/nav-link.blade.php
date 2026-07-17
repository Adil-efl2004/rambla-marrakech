@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-brass text-sm font-medium leading-5 text-brass focus:outline-none focus:border-brass transition-colors duration-200 [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0'
            : 'inline-flex items-center gap-2 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-parchment/80 hover:text-brass hover:border-brass/70 focus:outline-none focus:text-brass focus:border-brass/70 transition-colors duration-200 [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
