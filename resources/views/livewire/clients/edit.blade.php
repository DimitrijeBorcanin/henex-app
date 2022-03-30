<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Izmena klijenta
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="update">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            
        </x-slot>
    
        <x-slot name="form">      
            <!-- Date -->
            <div class="col-span-6">
                <x-jet-label for="first_date" value="Datum prvog dolaska" />
                <x-jet-input id="first_date" type="date" class="mt-1 block w-full" wire:model.defer="clientFields.first_date"/>
                <x-jet-input-error for="first_date" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="full_name" value="Ime i prezime" />
                <x-jet-input id="full_name" type="text" class="mt-1 block w-full" wire:model.defer="clientFields.full_name"/>
                <x-jet-input-error for="full_name" class="mt-2" />
            </div>

            <div class="col-span-3">
                <label for="site" class="flex items-center">
                    <x-jet-checkbox id="site" wire:model.defer="clientFields.site" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Sajt</span>
                </label>
                <x-jet-input-error for="site" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="recommendation" class="flex items-center">
                    <x-jet-checkbox id="recommendation" wire:model.defer="clientFields.recommendation" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Preporuka</span>
                </label>
                <x-jet-input-error for="recommendation" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="internet" class="flex items-center">
                    <x-jet-checkbox id="internet" wire:model.defer="clientFields.internet" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Internet</span>
                </label>
                <x-jet-input-error for="internet" class="mt-2" />
            </div>
            <div class="col-span-3">
                <label for="totems" class="flex items-center">
                    <x-jet-checkbox id="totems" wire:model.defer="clientFields.totems" value="1" />
                    <span class="ml-2 text-sm text-gray-600">Totemi</span>
                </label>
                <x-jet-input-error for="totems" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="last_date" value="Datum poslednjeg dolaska" />
                <x-jet-input id="last_date" type="date" class="mt-1 block w-full" wire:model.defer="clientFields.last_date"/>
                <x-jet-input-error for="last_date" class="mt-2" />
            </div>

            <div class="col-span-6">
                <x-jet-label for="reason" value="Razlog nedolaska (ako postoji)" />
                <x-jet-input id="reason" type="text" class="mt-1 block w-full" wire:model.defer="clientFields.reason"/>
                <x-jet-input-error for="reason" class="mt-2" />
            </div>
            
            @if(Auth::user()->role_id == 1)
            <!-- location -->
            <div class="col-span-4">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="clientFields.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
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
