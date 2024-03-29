<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Ostali prihodi
    </h2>
</x-slot>
<div>

    <div wire:loading.flex wire:target="resetPage" class="absolute w-full h-screen flex justify-center items-center z-50 top-0 left-0 bg-black/50">
        <div>
            <i class="fa-solid fa-spinner text-8xl text-white animate-spin"></i>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="flex justify-between">
            @if(Auth::user()->role_id != 3)
            <div class="w-full mb-3 px-3 md:px-0 flex">
                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_from" value="Datum od" />
                    <x-jet-input id="date_from" type="date" class="mt-1 block w-full" wire:model="filter.date_from" />
                </div>

                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_to" value="Datum do" />
                    <x-jet-input id="date_to" type="date" class="mt-1 block w-full" wire:model="filter.date_to" />
                </div>
    
                <div class="w-1/5 mr-2">
                    <x-jet-label for="incomeType" value="Vrsta troška" />
                    <select wire:model="filter.incomeType" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="incomeType">
                        <option value="0">Sve</option>
                        @foreach($incomeTypes as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @endforeach
                    </select>
                </div>
                @if(Auth::user()->role_id != 3)
                <div class="w-1/5">
                    <x-jet-label for="location" value="Lokacija" />
                    <select wire:model="filter.location" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="location">
                        <option value="0">Sve</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            @endif
            <div class="flex">
                <div onClick="window.location='{{route('incomes.create')}}'" class="mr-3 @if(Auth::user()->role_id == 3) px-3 @else w-12 @endif h-12 cursor-pointer flex justify-center items-center self-center rounded bg-gray-200 hover:bg-gray-500 hover:text-white">
                    <i class="fa-solid fa-plus grow-0"></i> @if(Auth::user()->role_id == 3) Dodaj prihod @endif
                </div>
                @if(Auth::user()->role_id != 3)
                <div class="w-12 h-12 cursor-pointer flex justify-center items-center self-center rounded bg-gray-200 hover:bg-gray-500 hover:text-white"
                wire:click="resetPage">
                    <i class="fa-solid fa-arrows-rotate grow-0"></i>
                </div>
                @endif
            </div>
        </div>
        
        {{-- @if(Auth::user()->role_id != 3) --}}
        <div wire:loading.remove wire:target="resetPage" class="overflow-x-auto w-full">
            <table class="min-w-full w-full divide-y divide-gray-200 mb-3">
                <thead>
                    <tr>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Vrsta prihoda</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Gotovina</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Bezgotovina</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($incomes as $income)
                        <tr wire:key="income_{{$income->id}}">
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$income->formatted_income_date}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$income->incomeType->name}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$income->formatted_cash}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$income->formatted_non_cash}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap text-right">
                                <a href="{{route('incomes.show', ["income" => $income->id])}}">
                                    <x-jet-secondary-button><i class="fa-solid fa-eye"></i></x-jet-secondary-button>
                                </a>
                                <a href="{{route('incomes.edit', ["income" => $income->id])}}">
                                    <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
                                </a>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="5">Nemate nijedan prihod ili ne postoji prihod sa unetom pretragom.</td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
            {{ $incomes->links('pagination.custom-pagination') }}
        </div>
        {{-- @endif --}}
    </div>
</div>