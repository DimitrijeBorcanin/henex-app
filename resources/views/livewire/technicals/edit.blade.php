<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Izmena tehničkog pregleda: {{$technical->formatted_tech_date}} - {{$technical->reg_number}}
    </h2>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <x-jet-form-section submit="update">
        <x-slot name="title">
            
        </x-slot>
    
        <x-slot name="description">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Upozorenje!</strong>
                <span class="block sm:inline">Promena podataka za tehnički pregled može dovesti do neslaganja sa ostalim podacima u bazi.</span>
              </div>
        </x-slot>
    
        <x-slot name="form">      
            <!-- Reg Number -->
            <div class="col-span-6">
                <x-jet-label for="reg_number" value="Registarski broj vozila" />
                <x-jet-input id="reg_number" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.reg_number"/>
                <x-jet-input-error for="reg_number" class="mt-2" />
            </div>
            <!-- Location -->
            <div class="col-span-4">
                <x-jet-label for="location_id" value="Lokacija" />
                <select wire:model.defer="technicalFields.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
                    <option value="0">Izaberite...</option>
                    @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="location_id" class="mt-2" />
            </div>
            {{-- Date --}}
            <div class="col-span-2">
                <x-jet-label for="tech_date" value="Datum" />
                <x-jet-input id="tech_date" type="date" class="mt-1 block w-full" wire:model.defer="technicalFields.tech_date"/>
                <x-jet-input-error for="tech_date" class="mt-2" />
            </div>

            <!-- Reg -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Registracija</h2>
            </div>
            <div class="col-span-3">
                <x-jet-label for="reg_cash" value="Gotovina" />
                <x-jet-input id="reg_cash" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.reg_cash"/>
                <x-jet-input-error for="reg_cash" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="reg_check" value="Ček" />
                <x-jet-input id="reg_check" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.reg_check"/>
                <x-jet-input-error for="reg_check" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="reg_card" value="Kartica" />
                <x-jet-input id="reg_card" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.reg_card"/>
                <x-jet-input-error for="reg_card" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="reg_firm" value="Faktura" />
                <x-jet-input id="reg_firm" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.reg_firm"/>
                <x-jet-input-error for="reg_firm" class="mt-2" />
            </div>

            <!-- Tech -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Tehnički</h2>
            </div>
            <div class="col-span-3">
                <x-jet-label for="tech_cash" value="Gotovina" />
                <x-jet-input id="tech_cash" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.tech_cash"/>
                <x-jet-input-error for="tech_cash" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="tech_check" value="Ček" />
                <x-jet-input id="tech_check" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.tech_check"/>
                <x-jet-input-error for="tech_check" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="tech_card" value="Kartica" />
                <x-jet-input id="tech_card" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.tech_card"/>
                <x-jet-input-error for="tech_card" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="tech_invoice" value="Faktura" />
                <x-jet-input id="tech_invoice" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.tech_invoice"/>
                <x-jet-input-error for="tech_invoice" class="mt-2" />
            </div>

            <div class="col-span-3">
                <x-jet-label for="agency" value="Agencija" />
                <x-jet-input id="agency" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.agency"/>
                <x-jet-input-error for="agency" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="voucher" value="Vaučer" />
                <x-jet-input id="voucher" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.voucher"/>
                <x-jet-input-error for="voucher" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="adm" value="ADM" />
                <x-jet-input id="adm" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.adm"/>
                <x-jet-input-error for="adm" class="mt-2" />
            </div>

            <!-- Insurance company -->
            <div class="col-span-12 text-xl mt-3">
                <h2>Polisa</h2>
            </div>
            <div class="col-span-3">
                <x-jet-label for="policy" value="Neto" />
                <x-jet-input id="policy" type="text" class="mt-1 block w-full" wire:model.defer="technicalFields.policy"/>
                <x-jet-input-error for="policy" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="insurance_company_id" value="Osiguranje" />
                <select wire:model.defer="technicalFields.insurance_company_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="insurance_company_id">
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
