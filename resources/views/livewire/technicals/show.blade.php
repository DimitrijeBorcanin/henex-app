<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tehnički pregled {{ $technical->formatted_tech_date }} - {{$technical->reg_number}} @if($technical->returning) Povratnik @endif
        </h2>
        @if(Auth::user()->role_id != 3 || (Auth::user()->role_id == 3 && $technical->tech_date == Carbon\Carbon::now()->toDateString('YYYY-mm-dd')))
        <a href="{{route('technicals.edit', ["technical" => $technical->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a>
        @endif
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Registracija</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2>Gotovina:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('reg_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Ček:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('reg_check')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Kartica:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('reg_card')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Firma:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('reg_firm')}}</h2>
        </div>

        <!-- Tech -->
        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Tehnički ({{$technical->formatted_tech_sum}} din.)</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2>Gotovina:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('tech_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Ček:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('tech_check')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Kartica:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('tech_card')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Faktura:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('tech_invoice')}}</h2>
        </div>

        <div class="col-span-3 mt-2">
            <h2>Agencija:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('agency')}}</h2>
        </div>
        <div class="col-span-3 mt-2">
            <h2>Vaučer:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('voucher')}}</h2>
        </div>
        <div class="col-span-3 mt-2">
            <h2>ADM:</h2>
            <h2 class="text-xl">{{$technical->getFormattedAmount('adm')}}</h2>
        </div>

        <!-- Insurance company -->
        
        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Polisa</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2 class="text-xl">@if($technical->insurance_company_id){{$technical->insuranceCompany->name}}@endif {{$technical->getFormattedAmount('policy')}}</h2>
        </div>
        
        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Iznos registracije naplaćen sa provizijom</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2 class="text-3xl">{{$technical->formatted_total ? $technical->formatted_total . ' din.' : '-'}}</h2>
        </div>
    </div>
</div>