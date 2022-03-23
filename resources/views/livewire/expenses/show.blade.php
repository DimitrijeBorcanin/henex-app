<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled troška
        </h2>
        <a href="{{route('expenses.edit', ["expense" => $expense->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum:</h2>
            <h2 class="text-xl">{{$expense->formatted_expense_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Vrtsa troška:</h2>
            <h2 class="text-xl">{{$expense->expenseType->name}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Gotovina:</h2>
            <h2 class="text-xl">{{$expense->formatted_cash}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Bezgotovina:</h2>
            <h2 class="text-xl">{{$expense->formatted_non_cash}}</h2>
        </div>
        <div class="col-span-12">
            <h2>Dodatni opis:</h2>
            <h2 class="text-xl">{{$expense->description ?? '-'}}</h2>
        </div>
    </div>
</div>