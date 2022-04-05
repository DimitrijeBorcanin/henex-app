<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Korisnici
    </h2>
</x-slot>
<div>

    <div wire:loading.flex wire:target="resetPage" class="absolute w-full h-screen flex justify-center items-center z-50 top-0 left-0 bg-black/50">
        <div>
            <i class="fa-solid fa-spinner text-8xl text-white animate-spin"></i>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="createModalVisible">
        <x-slot name="title">
            {{ __('Dodajte korisnika') }}
        </x-slot>
    
        <x-slot name="content">  
            <form>
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="name" value="Ime" />
                    <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="user.name" autocomplete="name" />
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
        
                <!-- Email -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="email" value="Email" />
                    <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="user.email" />
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
        
                <!-- Password -->
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="password" value="Lozinka" />
                    <x-jet-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="user.password" autocomplete="password" />
                    <x-jet-input-error for="password" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="password_confirmation" value="Potvrda lozinke" />
                    <x-jet-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="user.password_confirmation" autocomplete="password" />
                    <x-jet-input-error for="password_confirmation" class="mt-2" />
                </div>
        
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="role_id" value="Uloga" />
                    <select wire:change="changeSelectedRole" wire:model.defer="user.role_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="role_id">
                        <option value="0">Izaberite...</option>
                        @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="role_id" class="mt-2" />
                </div>
                @if($user["role_id"] == 3)
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="location_id" value="Lokacija" />
                    <select wire:model.defer="user.location_id" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="location_id">
                        <option value="0">Izaberite...</option>
                        @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="location_id" class="mt-2" />
                </div>
                @endif
                @if($user["role_id"] == 2)
                <div class="col-span-6 sm:col-span-4 mb-4">
                    <x-jet-label for="locations" value="Lokacija" />
                    <select multiple wire:model.defer="user.locations" class="form-input rounded-md shadow-sm block mt-1 w-full py-2" id="locations">
                        @foreach($locations as $location)
                                <option value="{{$location->id}}" @if($userToUpdate && in_array($location->id, $userToUpdate->locations()->pluck('location_id')->toArray())) selected="selected" @endif>{{$location->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for="locations" class="mt-2" />
                </div>
                @endif
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
        <div class="flex justify-between">
            <div class="w-full mb-3 px-3 md:px-0 flex">
                <div class="w-1/5 mr-2">
                    <x-jet-label for="search" value="Pretraga" />
                    <x-jet-input id="search" type="text" class="mt-1 block w-full" wire:model.debounce.500ms="filter.search" />
                    <x-jet-input-error for="search" class="mt-2" />
                </div>
    
                <div class="w-1/5 mr-2">
                    <x-jet-label for="role" value="Uloga" />
                    <select wire:model="filter.role" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="role">
                        <option value="0">Svi</option>
                        @foreach($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select>
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
                wire:click="showCreateModal">
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
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Ime</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Uloga</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Lokacija</th>
                        <th class="w-1/5 px-6 py-3 bg-gray-50 text-right text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr wire:key="user_{{$user->id}}">
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$user->name}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$user->email}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$user->role->name}}</td>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap">{{$user->location ? $user->location->name : implode(", ", $user->locations()->pluck('name')->toArray())}}</td>
                            {{-- <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                <select class="form-select appearance-none
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Uloga"
                                autocomplete="off"
                                wire:change="updateRole({{$user->id}}, $event.target.value)">
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if($user->role_id == $role->id) selected @endif>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </td> --}}
                            {{-- <td class="px-6 py-4 text-sm whitespace-no-wrap">
                                <select class="form-select appearance-none
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding bg-no-repeat
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label="Lokacija"
                                wire:change="updateLocation({{$user->id}}, $event.target.value)"
                                autocomplete="off">
                                    @foreach($locations as $location)
                                        <option value="{{$location->id}}" @if($user->location_id == $location->id) selected @endif>{{$location->name}}</option>
                                    @endforeach
                                </select>
                            </td> --}}
                            <td class="px-6 py-4 text-sm whitespace-no-wrap text-right">
                                <x-jet-button wire:click="showCreateModal({{$user}})"><i class="fa-solid fa-pen"></i></x-jet-button>
                                <x-jet-danger-button wire:click="showDeleteModal({{$user}})"><i class="fa-solid fa-trash"></i></x-jet-danger-button>
                            </td>
                        </tr>
                    @empty 
                        <tr>
                            <td class="px-6 py-4 text-sm whitespace-no-wrap" colspan="5">Nemate nijednog zaposlenog ili ne postoji zaposleni sa unetom pretragom.</td>
                        </tr>
                    @endforelse
                    </tbody>
            </table>
            {{ $users->links('pagination.custom-pagination') }}
        </div>
    </div>

    <x-jet-confirmation-modal wire:model="deleteModalVisible">
        <x-slot name="title">
            Obrišite korisnika
        </x-slot>
    
        <x-slot name="content">
            @if($userToDelete != null)
            Da li ste siguni da želite da obrišete korisnika <b>{{$userToDelete['name']}}</b>?
            @endif
        </x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="cancelDelete" wire:loading.attr="disabled">
                Odustani
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                Obriši
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>