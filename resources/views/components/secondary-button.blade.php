<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-md border border-brass/40 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-ink shadow-sm transition-colors duration-200 hover:bg-brass/10 focus:outline-none focus:ring-2 focus:ring-brass focus:ring-offset-2 disabled:opacity-25 [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0']) }}>
    {{ $slot }}
</button>
