<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Izveštaji
        </h2>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="w-full mb-5 px-3 md:px-0 flex">
        <div class="w-1/5 mr-2">
            <x-jet-label for="month" value="Mesec" />
            <select wire:model="filter.month" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="month">
                @foreach($months as $no => $month)
                @if($filter["year"] != Carbon\Carbon::now()->year || ($filter["year"] == Carbon\Carbon::now()->year && $no <= Carbon\Carbon::now()->month))
                    <option value="{{$no}}">{{$month}}</option>
                @endif
                @endforeach
            </select>
        </div>

        <div class="w-1/5">
            <x-jet-label for="year" value="Godina" />
            <select wire:model="filter.year" class="form-input rounded-md shadow-sm block mt-1 py-2 w-full" id="year">
                @for($i=Carbon\Carbon::now()->year; $i>=2022; $i--)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-4">
            <h2>Broj tehničkih:</h2>
            <h2 class="text-xl">{{$reports["technical_no"]}}</h2>
        </div>

        <div class="col-span-4">
            <h2>Zarada:</h2>
            <h2 class="text-xl">{{number_format($reports["profit"], 2, ',', '.') . ' din.'}}</h2>
        </div>

        <div class="col-span-4">
            <h2>Polise:</h2>
            <h2 class="text-xl">{{number_format($reports["totalPolicy"], 2, ',', '.') . ' din.'}}</h2>
        </div>

        @foreach($reports["policies"] as $policy)
        <div class="col-span-2">
            <h2>{{$policy["name"]}}:</h2>
            <h2 class="text-xl">{{number_format($policy["amount"], 2, ',', '.') . ' din.'}}</h2>
        </div>
        @endforeach
    </div>
</div>
