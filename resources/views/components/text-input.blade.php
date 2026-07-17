@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-wa-border bg-wa-darker text-wa-text placeholder-wa-muted rounded-xl shadow-sm focus:border-wa-green focus:ring-wa-green/20']) }}>
