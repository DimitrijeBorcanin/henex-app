<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Unos početnog stanja kase
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
                <x-jet-label for="register_start">Stanje kase na početku dana <i class="fa-solid fa-spinner animate-spin" wire:loading.inline></i></x-jet-label>
                <x-jet-input id="register_start" type="text" class="mt-1 block w-full" wire:model.defer="state.register_start"/>
                <x-jet-input-error for="register_start" class="mt-2" />
            </div>
            @if(Auth::user()->role_id == 1)
            <div class="col-span-3">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="state.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id" wire:change="getPreviousState">
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
