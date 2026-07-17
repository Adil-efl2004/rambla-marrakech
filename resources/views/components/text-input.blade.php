@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-md border-ink/20 shadow-sm focus:border-brass focus:ring-brass']) }}>
