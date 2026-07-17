<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-wa-green hover:bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-wa-green focus:ring-offset-2 focus:ring-offset-wa-card transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
