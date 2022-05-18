<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Izmena stanja slipova za dan {{$slip->formatted_slip_date}} za lokaciju {{$slip->location->name}}
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="update">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            
        </x-slot>
    
        <x-slot name="form">
            <!-- Cash -->
            <div class="col-span-3">
                <x-jet-label for="status_start">Početno stanje <i class="fa-solid fa-spinner animate-spin" wire:loading.inline></i></x-jet-label>
                <x-jet-input id="status_start" type="text" class="mt-1 block w-full" wire:model.defer="slipFields.status_start" wire:loading.attr="disabled" />
                <x-jet-input-error for="status_start" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="received">Primljeno <i class="fa-solid fa-spinner animate-spin" wire:loading.inline></i></x-jet-label>
                <x-jet-input id="received" type="text" class="mt-1 block w-full" wire:model.defer="slipFields.received" wire:loading.attr="disabled" />
                <x-jet-input-error for="received" class="mt-2" />
            </div>
            @if(Auth::user()->role_id != 3)
            <div class="col-span-3">
                <x-jet-label for="location_id" value="Lokacija" />
                <select class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id" disabled>
                    <option>{{$slip->location->name}}</option>
                </select>
                <x-jet-input-error for="location_id" class="mt-2" />
            </div>
            @endif
        </x-slot>
    
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                Sačuvano
            </x-jet-action-message>
    
            <x-jet-button wire:loading.attr="disabled">
                Sačuvaj
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>
