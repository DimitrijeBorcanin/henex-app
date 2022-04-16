<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled slipova
        </h2>
        <a href="{{route('slips.edit', ["slip" => $slip->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum:</h2>
            <h2 class="text-xl">{{$slip->formatted_slip_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Početno stanje:</h2>
            <h2 class="text-xl">{{$slip->formatted_status_start}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Primljeno:</h2>
            <h2 class="text-xl">{{$slip->formatted_received}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Stanje:</h2>
            <h2 class="text-xl">{{$slip->formatted_status_end}} din.</h2>
        </div>
    </div>
</div>