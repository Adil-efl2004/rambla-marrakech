<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-md border border-transparent bg-coral px-4 py-2 text-xs font-semibold uppercase tracking-widest text-ink transition-colors duration-200 hover:bg-ink hover:text-parchment focus:outline-none focus:ring-2 focus:ring-coral focus:ring-offset-2 active:bg-ink [&_svg]:h-6 [&_svg]:w-6 [&_svg]:shrink-0']) }}>
    {{ $slot }}
</button>
