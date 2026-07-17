@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-wa-muted']) }}>
    {{ $value ?? $slot }}
</label>
