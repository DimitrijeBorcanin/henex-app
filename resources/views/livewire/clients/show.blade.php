<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled klijenta
        </h2>
        <a href="{{route('clients.edit', ["client" => $client->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum prvog dolaska:</h2>
            <h2 class="text-xl">{{$client->formatted_first_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Ime i prezime:</h2>
            <h2 class="text-xl">{{$client->full_name}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Kako su došli:</h2>
            @if($client->site) <h2 class="text-xl">Sajt</h2> @endif
            @if($client->recommendation) <h2 class="text-xl">Preporuka</h2> @endif
            @if($client->internet) <h2 class="text-xl">Internet</h2> @endif
            @if($client->totems) <h2 class="text-xl">Totemi</h2> @endif
        </div>
        <div class="col-span-3">
            <h2>Datum poslednjeg dolaska:</h2>
            <h2 class="text-xl">{{$client->formatted_last_date}}</h2>
        </div>
        @if($client->reason)
        <div class="col-span-3">
            <h2>Razlog za nedolaženje:</h2>
            <h2 class="text-xl">{{$client->reason}}</h2>
        </div>
        @endif
    </div>
</div>