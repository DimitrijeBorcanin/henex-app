<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Izmena troška
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
                <x-jet-label for="expense_date" value="Datum" />
                <x-jet-input id="expense_date" type="date" class="mt-1 block w-full" wire:model.defer="expenseFields.expense_date"/>
                <x-jet-input-error for="expense_date" class="mt-2" />
            </div>
            <!-- Expense type -->
            <div class="col-span-4">
                <x-jet-label for="expense_type_id" value="Vrsta troška" />
                <select wire:model.defer="expenseFields.expense_type_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="expense_type_id">
                    <option value="0">Izaberite...</option>
                    @foreach($expenseTypes as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                <x-jet-input-error for="expense_type_id" class="mt-2" />
            </div>
            <!-- Cash -->
            <div class="col-span-3">
                <x-jet-label for="cash" value="Gotovina" />
                <x-jet-input id="cash" type="text" class="mt-1 block w-full" wire:model.defer="expenseFields.cash"/>
                <x-jet-input-error for="cash" class="mt-2" />
            </div>
            <div class="col-span-3">
                <x-jet-label for="non_cash" value="Bezgotovina" />
                <x-jet-input id="non_cash" type="text" class="mt-1 block w-full" wire:model.defer="expenseFields.non_cash"/>
                <x-jet-input-error for="non_cash" class="mt-2" />
            </div>

            <div class="col-span-12">
                <x-jet-label for="description" value="Opis" />
                <x-jet-input id="description" type="text" class="mt-1 block w-full" wire:model.defer="expenseFields.description"/>
                <x-jet-input-error for="description" class="mt-2" />
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
