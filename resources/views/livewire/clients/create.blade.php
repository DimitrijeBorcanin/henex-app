<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Novi klijent
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="store">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            
        </x-slot>
    
        <x-slot name="form">      
            <!-- Date -->
            <div class="col-span-6">
                <x-jet-label for="first_date" value="Datum" />
                <x-jet-input id="first_date" type="date" class="mt-1 block w-full" wire:model.defer="client.first_date"/>
                <x-jet-input-error for="first_date" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="full_name" value="Ime i prezime" />
                <x-jet-input id="full_name" type="text" class="mt-1 block w-full" wire:model.defer="client.full_name"/>
                <x-jet-input-error for="full_name" class="mt-2" />
            </div>

            <div class="col-span-3">
                <label for="site" class="flex items-center">
                    <x-jet-checkbox id="site" wire:model.defer="client.site" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Sajt</span>
                </label>
                <x-jet-input-error for="site" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="recommendation" class="flex items-center">
                    <x-jet-checkbox id="recommendation" wire:model.defer="client.recommendation" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Preporuka</span>
                </label>
                <x-jet-input-error for="recommendation" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="internet" class="flex items-center">
                    <x-jet-checkbox id="internet" wire:model.defer="client.internet" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Internet</span>
                </label>
                <x-jet-input-error for="internet" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="totems" class="flex items-center">
                    <x-jet-checkbox id="totems" wire:model.defer="client.totems" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Totemi</span>
                </label>
                <x-jet-input-error for="totems" class="mt-2" />
            </div>
            
            @if(Auth::user()->role_id == 1)
            <!-- location -->
            <div class="col-span-4">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="client.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
                    <option value="0">Izaberite...</option>
                    @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
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
