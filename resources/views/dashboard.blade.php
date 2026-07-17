<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-wa-text leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-wa-card border border-wa-border overflow-hidden shadow-card sm:rounded-2xl">
                <div class="p-6 text-wa-text">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
