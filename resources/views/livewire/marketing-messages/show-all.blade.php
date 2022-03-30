<div>

    <div wire:loading.flex wire:target="resetPage" class="absolute w-full h-screen flex justify-center items-center z-50 top-0 left-0 bg-black/50">
        <div>
            <i class="fa-solid fa-spinner text-8xl text-white animate-spin"></i>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="createModalVisible">
        <x-slot name="title">
            {{ __('Dodajte poruke') }}
        </x-slot>
    
        <x-slot name="content">
            <form>
                <!-- Date -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="sent_date" value="Datum" />
                    <x-jet-input id="sent_date" type="date" class="mt-1 block w-full" wire:model.defer="message.sent_date" />
                    <x-jet-input-error for="sent_date" class="mt-2" />
                </div>
        
                <!-- No -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="viber" value="Viber" />
                    <x-jet-input id="viber" type="text" class="mt-1 block w-full" wire:model.defer="message.viber" />
                    <x-jet-input-error for="viber" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="sms" value="SMS" />
                    <x-jet-input id="sms" type="text" class="mt-1 block w-full" wire:model.defer="message.sms" />
                    <x-jet-input-error for="sms" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="letter" value="Pisma" />
                    <x-jet-input id="letter" type="text" class="mt-1 block w-full" wire:model.defer="message.letters" />
                    <x-jet-input-error for="letter" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="location_id" value="Lokacija" />
                    <select wire:model.defer="message.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
                        <option value="0">Izaberite...</option>
                        @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="location_id" class="mt-2" />
                </div>
            </form>
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelCreate" wire:loading.attr="disabled">
                {{ __('Odustani') }}
            </x-jet-secondary-button>
    
            <x-jet-button class="ml-2" wire:click="submitForm" wire:loading.attr="disabled">
                @if($isEdit)
                {{ __('Izmeni') }}
                @else
                {{ __('Dodaj') }}
                @endif
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <h2 class="text-2xl mb-3">Poruke</h2>
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
                <div class="mr-3 w-12 h-12 cursor-pointer flex justify-center items-center self-center rounded bg-gray-200 hover:bg-gray-500 hover:text-white"
                    wire:click="showCreateModal"
                >
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
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Viber</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">SMS</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Pisma</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($messages as $message)
                        <tr wire:key="message_{{$message->id}}">
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$message->formatted_sent_date}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$message->viber}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$message->sms}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$message->letters}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap text-right">
                                <x-jet-button wire:click="showCreateModal({{$message}})"><i class="fa-solid fa-pen"></i></x-jet-button>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="5">Nemate nijednu poruku ili ne postoji poruka sa unetom pretragom.</td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
            {{ $messages->links('pagination.custom-pagination') }}
        </div>
    </div>
</div>