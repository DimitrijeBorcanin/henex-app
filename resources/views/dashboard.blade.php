<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('general.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                @if(Auth::user()->role_id == 1)
                <a href="{{route('users')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-user"></i> Korisnici
                    </div>
                </a>
                @endif
                
                <a class="stateSetDash" href="{{route('technicals')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-car"></i> Tehnički pregledi
                    </div>
                </a>

                <a class="stateSetDash" href="{{route('expenses')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-money-bill"></i> Troškovi
                    </div>
                </a>

                <a class="stateSetDash" href="{{route('incomes')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-money-bill"></i> Prihodi
                    </div>
                </a>

                @if(Auth::user()->role_id == 1)
                <a href="{{route('checks')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-money-bill"></i> Čekovi
                    </div>
                </a>
                @endif

                @if(Auth::user()->role_id == 1)
                <a href="{{route('slips')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-money-bill"></i> Slipovi
                    </div>
                </a>
                @endif

                <a href="{{route('marketing')}}">
                    <div class="bg-white p-5 text-2xl rounded hover:drop-shadow-md hover:scale-105 ease-in-out duration-300">
                        <i class="fa-solid fa-chart-simple"></i> Marketing
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
