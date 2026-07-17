@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex w-full items-center gap-2 ps-3 pe-4 py-2 border-l-4 border-brass text-start text-base font-medium text-brass bg-parchment/10 focus:outline-none focus:text-brass focus:bg-parchment/10 focus:border-brass transition-colors duration-200 [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0'
            : 'flex w-full items-center gap-2 ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-parchment/80 hover:text-brass hover:bg-parchment/10 hover:border-brass/70 focus:outline-none focus:text-brass focus:bg-parchment/10 focus:border-brass/70 transition-colors duration-200 [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
