<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled prihoda
        </h2>
        <a href="{{route('incomes.edit', ["income" => $income->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum:</h2>
            <h2 class="text-xl">{{$income->formatted_income_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Vrtsa prihoda:</h2>
            <h2 class="text-xl">{{$income->incomeType->name}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Gotovina:</h2>
            <h2 class="text-xl">{{$income->formatted_cash != 0 ? $income->formatted_cash . ' din.' : '-'}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Bezgotovina:</h2>
            <h2 class="text-xl">{{$income->formatted_non_cash != 0 ? $income->formatted_non_cash . ' din.' : '-'}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Datum izvoda:</h2>
            <h2 class="text-xl">{{$income->formatted_excerpt_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Stanje izvoda na dan:</h2>
            <h2 class="text-xl">{{$income->formatted_excerpt_status != 0 ? $income->formatted_excerpt_status . ' din.' : '-'}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Lokacija:</h2>
            <h2 class="text-xl">{{$income->location->name}}</h2>
        </div>
        <div class="col-span-12">
            <h2>Dodatni opis:</h2>
            <h2 class="text-xl">{{$income->description ?? '-'}}</h2>
        </div>
    </div>
</div>