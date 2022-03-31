<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Čekovi
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
            <div class="w-full mb-3 px-3 md:px-0 flex">
                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_from" value="Datum od" />
                    <x-jet-input id="date_from" type="date" class="mt-1 block w-full" wire:model="filter.date_from" />
                </div>

                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_to" value="Datum do" />
                    <x-jet-input id="date_to" type="date" class="mt-1 block w-full" wire:model="filter.date_to" />
                </div>

                <div class="w-1/5">
                    <x-jet-label for="location" value="Lokacija" />
                    <select wire:model="filter.location" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="location">
                        <option value="0">Sve</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex">
                <div onClick="window.location='{{route('checks.create')}}'" class="mr-3 w-12 h-12 cursor-pointer flex justify-center items-center self-center rounded bg-gray-200 hover:bg-gray-500 hover:text-white">
                    <i class="fa-solid fa-plus grow-0"></i>
                </div>
                <div class="w-12 h-12 cursor-pointer flex justify-center items-center self-center rounded bg-gray-200 hover:bg-gray-500 hover:text-white"
                wire:click="resetPage">
                    <i class="fa-solid fa-arrows-rotate grow-0"></i>
                </div>
            </div>
        </div>
        
        <div wire:loading.remove wire:target="resetPage" class="overflow-x-auto w-full">
            <table class="min-w-full w-full divide-y divide-gray-200 mb-3">
                <thead>
                    <tr>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Početno stanje</th>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Primljeni</th>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Razduženi</th>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Stanje</th>
                        <th class="w-1/6 px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($checks as $check)
                        <tr wire:key="check_{{$check->id}}">
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$check->formatted_check_date}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$check->formatted_status_start}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$check->formatted_received}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$check->formatted_debited}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$check->formatted_status_end}} din.</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap text-right">
                                <a href="{{route('checks.show', ["check" => $check->id])}}">
                                    <x-jet-secondary-button><i class="fa-solid fa-eye"></i></x-jet-secondary-button>
                                </a>
                                <a href="{{route('checks.edit', ["check" => $check->id])}}">
                                    <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
                                </a>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="6">Nemate nijedan ček ili ne postoji ček sa unetom pretragom.</td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
            {{ $checks->links('pagination.custom-pagination') }}
        </div>
    </div>
</div>