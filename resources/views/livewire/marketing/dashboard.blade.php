<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Marketing
        </h2>
    </x-slot>

    <livewire:clients.show-all />
    <livewire:clients.not-returned />
    <livewire:marketing-messages.show-all />
</x-app-layout>