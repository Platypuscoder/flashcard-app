<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black  leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="p-12">
        @livewire('Admin.DeckWidget')
    </div>
</x-app-layout>
