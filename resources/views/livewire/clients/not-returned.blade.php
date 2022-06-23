<div>

    <div wire:loading.flex wire:target="resetPage" class="absolute w-full h-screen flex justify-center items-center z-50 top-0 left-0 bg-black/50">
        <div>
            <i class="fa-solid fa-spinner text-8xl text-white animate-spin"></i>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl mb-3">Klijenti koji nisu došli na registraciju</h2>
        <div class="flex justify-between">
            <div class="w-full mb-3 px-3 md:px-0 flex">
                <div class="w-1/5 mr-2">
                    <x-jet-label for="search" value="Pretraga" />
                    <x-jet-input id="search2" type="text" class="mt-1 block w-full" wire:model="filterNotReturned.search" />
                </div>

                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_from" value="Datum od" />
                    <x-jet-input id="date_from2" type="date" class="mt-1 block w-full" wire:model="filterNotReturned.date_from" />
                </div>

                <div class="w-1/5 mr-2">
                    <x-jet-label for="date_to" value="Datum do" />
                    <x-jet-input id="date_to2" type="date" class="mt-1 block w-full" wire:model="filterNotReturned.date_to" />
                </div>
                @if(Auth::user()->role_id != 3)
                <div class="w-1/5">
                    <x-jet-label for="location" value="Lokacija" />
                    <select wire:model="filterNotReturned.location" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="location2">
                        <option value="0">Sve</option>
                        @foreach($locations as $location)
                            <option value="{{$location->id}}">{{$location->name}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            <div class="flex">
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
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Poslednji datum</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ime i prezime</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Razlog</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($notReturned as $client)
                        <tr wire:key="client_{{$client->id}}">
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$client->formatted_last_date}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$client->full_name}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$client->reason}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap text-right">
                                <a href="{{route('clients.show', ["client" => $client->id])}}">
                                    <x-jet-secondary-button><i class="fa-solid fa-eye"></i></x-jet-secondary-button>
                                </a>
                                <a href="{{route('clients.edit', ["client" => $client->id])}}">
                                    <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
                                </a>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="5">Nemate nijednog klijenta ili ne postoji klijent sa unetom pretragom.</td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
            {{ $notReturned->links('pagination.custom-pagination') }}
        </div>
    </div>
</div>