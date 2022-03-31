<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled čekova
        </h2>
        <a href="{{route('checks.edit', ["check" => $check->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum:</h2>
            <h2 class="text-xl">{{$check->formatted_check_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Početno stanje:</h2>
            <h2 class="text-xl">{{$check->formatted_status_start}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Primljeni:</h2>
            <h2 class="text-xl">{{$check->formatted_received}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Razduženi:</h2>
            <h2 class="text-xl">{{$check->formatted_debited}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Stanje:</h2>
            <h2 class="text-xl">{{$check->formatted_status_end}} din.</h2>
        </div>
    </div>
</div>