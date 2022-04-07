<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Novi tehnički pregled
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="store">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            
        </x-slot>
    
        <x-slot name="form">      
            <!-- Reg Number -->
            <div class="col-span-3">
                <x-jet-label for="reg_number" value="Registarski broj vozila" />
                <x-jet-input id="reg_number" type="text" class="mt-1 block w-full" wire:model.defer="technical.reg_number"/>
                <x-jet-input-error for="reg_number" class="mt-2" />
            </div>
            <!-- Total -->
            <div class="col-span-2">
                <x-jet-label for="total" value="Ukupan iznos" />
                <x-jet-input id="total" type="text" class="mt-1 block w-full" wire:model.defer="technical.total" wire:change="calculateDifference"/>
                <x-jet-input-error for="total" class="mt-2" />
            </div>
            <!-- Location -->
            @if(Auth::user()->role_id != 3)
            <div class="col-span-3">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="technical.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
                    <option value="0">Izaberite...</option>
                    @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="location_id" class="mt-2" />
            </div>
            @endif
            
            <div class="col-span-2 mt-5">
                <label for="returning" class="flex items-center mt-3">
                    <x-jet-checkbox id="returning" wire:model.defer="technical.returning" />
                    <span class="ml-2 text-sm text-gray-600">Povratnik</span>
                </label>
                <x-jet-input-error for="returning" class="mt-2" />
            </div>

            <!-- Reg -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Registracija</h2>
            </div>
            <div class="col-span-3 flex items-center">
                <div>
                    <x-jet-label for="reg_cash" value="Gotovina" />
                    <x-jet-input id="reg_cash" type="text" class="mt-1 block w-full" wire:model.defer="technical.reg_cash"/>
                    <x-jet-input-error for="reg_cash" class="mt-2" />
                </div>      
                <div class="ml-3 mt-4">
                    <input class="radioCheck" type="radio" value="reg_cash" wire:model="autofillPayment" wire:change="calculateDifference" />
                </div>
            </div>
            <div class="col-span-3 flex items-center">
                <div>
                    <x-jet-label for="reg_check" value="Ček" />
                    <x-jet-input id="reg_check" type="text" class="mt-1 block w-full" wire:model.defer="technical.reg_check"/>
                    <x-jet-input-error for="reg_check" class="mt-2" />
                </div>
                <div class="ml-3 mt-4">
                    <input class="radioCheck" type="radio" value="reg_check" wire:model="autofillPayment" wire:change="calculateDifference" />
                </div>
            </div>
            <div class="col-span-3 flex items-center">
                <div>
                    <x-jet-label for="reg_card" value="Kartica" />
                    <x-jet-input id="reg_card" type="text" class="mt-1 block w-full" wire:model.defer="technical.reg_card"/>
                    <x-jet-input-error for="reg_card" class="mt-2" />
                </div>
                <div class="ml-3 mt-4">
                    <input class="radioCheck" type="radio" value="reg_card" wire:model="autofillPayment" wire:change="calculateDifference" />
                </div>
            </div>
            <div class="col-span-3 flex items-center">
                <div>
                    <x-jet-label for="reg_firm" value="Faktura" />
                    <x-jet-input id="reg_firm" type="text" class="mt-1 block w-full" wire:model.defer="technical.reg_firm"/>
                    <x-jet-input-error for="reg_firm" class="mt-2" />
                </div>
                <div class="ml-3 mt-4">
                    <input class="radioCheck" type="radio" value="reg_firm" wire:model="autofillPayment" wire:change="calculateDifference" />
                </div>
            </div>

            <!-- Tech -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Tehnički</h2>
            </div>
            <div class="col-span-3">
                <div>
                    <x-jet-label for="tech_cash" value="Gotovina" />
                    <x-jet-input id="tech_cash" type="text" class="mt-1 block w-full" wire:model.defer="technical.tech_cash" wire:change="calculateDifference"/>
                    <x-jet-input-error for="tech_cash" class="mt-2" />
                </div>
            </div>
            <div class="col-span-3">
                <div>
                    <x-jet-label for="tech_check" value="Ček" />
                    <x-jet-input id="tech_check" type="text" class="mt-1 block w-full" wire:model.defer="technical.tech_check" wire:change="calculateDifference"/>
                    <x-jet-input-error for="tech_check" class="mt-2" />
                </div>
            </div>
            <div class="col-span-3">
                <div>
                    <x-jet-label for="tech_card" value="Kartica" />
                    <x-jet-input id="tech_card" type="text" class="mt-1 block w-full" wire:model.defer="technical.tech_card" wire:change="calculateDifference"/>
                    <x-jet-input-error for="tech_card" class="mt-2" />
                </div>
            </div>
            <div class="col-span-3">
                <div>
                    <x-jet-label for="tech_invoice" value="Faktura" />
                    <x-jet-input id="tech_invoice" type="text" class="mt-1 block w-full" wire:model.defer="technical.tech_invoice" wire:change="calculateDifference"/>
                    <x-jet-input-error for="tech_invoice" class="mt-2" />
                </div>
            </div>

            <div class="col-span-3">
                <x-jet-label for="agency" value="Agencija" />
                <x-jet-input id="agency" type="text" class="mt-1 block w-full" wire:model.defer="technical.agency"/>
                <x-jet-input-error for="agency" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="voucher" value="Vaučer" />
                <x-jet-input id="voucher" type="text" class="mt-1 block w-full" wire:model.defer="technical.voucher"/>
                <x-jet-input-error for="voucher" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="adm" value="ADM" />
                <x-jet-input id="adm" type="text" class="mt-1 block w-full" wire:model.defer="technical.adm"/>
                <x-jet-input-error for="adm" class="mt-2" />
            </div>

            <!-- Insurance company -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Polisa</h2>
            </div>
            <div class="col-span-3">
                <x-jet-label for="policy" value="Neto" />
                <x-jet-input id="policy" type="text" class="mt-1 block w-full" wire:model.defer="technical.policy"/>
                <x-jet-input-error for="policy" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="insurance_company_id" value="Osiguranje" />
                <select wire:model.defer="technical.insurance_company_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="insurance_company_id">
                    <option value="0">Izaberite...</option>
                    @foreach($companies as $company)
                            <option value="{{$company->id}}">{{$company->name}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="insurance_company_id" class="mt-2" />
            </div>
            
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
