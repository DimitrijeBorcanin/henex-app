<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Novi čekovi
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="store">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            Odabirom datuma, automatski će se uneti stanje prethodnog radnog dana, ako takav dan postoji u bazi.
        </x-slot>
    
        <x-slot name="form">      
            <!-- Date -->
            {{-- <div class="col-span-3">
                <x-jet-label for="check_date" value="Datum" />
                <x-jet-input id="check_date" type="date" class="mt-1 block w-full" wire:model.defer="check.check_date" wire:change="checkLastDay"/>
                <x-jet-input-error for="check_date" class="mt-2" />
            </div> --}}
            <!-- Cash -->
            <div class="col-span-3">
                <x-jet-label for="status_start">Početno stanje <i class="fa-solid fa-spinner animate-spin" wire:loading.inline></i></x-jet-label>
                <x-jet-input id="status_start" type="text" class="mt-1 block w-full" wire:model.defer="check.status_start" wire:loading.attr="disabled" />
                <x-jet-input-error for="status_start" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="received" value="Primljeni" />
                <x-jet-input id="received" type="text" class="mt-1 block w-full" wire:model.defer="check.received"/>
                <x-jet-input-error for="received" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="debited" value="Razduženi" />
                <x-jet-input id="debited" type="text" class="mt-1 block w-full" wire:model.defer="check.debited"/>
                <x-jet-input-error for="debited" class="mt-2" />
            </div>

            @if(Auth::user()->role_id != 3)
            <div class="col-span-3">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="check.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
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
