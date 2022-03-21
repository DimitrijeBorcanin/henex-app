<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('general.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <a href="{{route('users')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-user"></i> Korisnici
                    </div>
                </a>
                
                <a href="{{route('technicals')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-car"></i> Tehnički pregledi
                    </div>
                </a>

                <a href="#">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-cash-register"></i> Kase
                    </div>
                </a>

                <a href="#">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-location-dot"></i> Lokacije
                    </div>
                </a>

                <a href="#">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-file-invoice"></i> Polise
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
