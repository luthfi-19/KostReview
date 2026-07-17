<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-wa-card border border-wa-border rounded-xl font-semibold text-xs text-wa-text uppercase tracking-widest shadow-sm hover:bg-wa-hover focus:outline-none focus:ring-2 focus:ring-wa-blue focus:ring-offset-2 focus:ring-offset-wa-card disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
