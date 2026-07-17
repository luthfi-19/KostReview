@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-wa-green']) }}>
        {{ $status }}
    </div>
@endif
