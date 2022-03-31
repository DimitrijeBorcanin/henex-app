<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pregled dnevnog stanja
        </h2>
        {{-- <a href="{{route('checks.edit', ["check" => $check->id])}}">
            <x-jet-button><i class="fa-solid fa-pen"></i></x-jet-button>
        </a> --}}
    </div>
</x-slot>

<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3">
            <h2>Datum:</h2>
            <h2 class="text-xl">{{$state->formatted_state_date}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Lokacija:</h2>
            <h2 class="text-xl">{{$state->location->name}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Stanje kase na početku dana:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('register_start')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Stanje kase na kraju dana:</h2>
            <h2 class="text-xl">{{$state->formatted_register_end}} din.</h2>
        </div>
        <div class="col-span-3">
            <h2>Rashod gotovina iznos:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('expenses_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Prihodi gotovina:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('incomes_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Broj vaučera na dan:</h2>
            <h2 class="text-xl">{{$state->voucher_no}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Broj tehničkih pregleda na dan:</h2>
            <h2 class="text-xl">{{$state->technical_no}}</h2>
        </div>

        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Registracija</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2>Registracija plaćena gotovinom:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('reg_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Registracija plaćena čekovima:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('reg_check')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Registracija plaćena karticom:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('reg_card')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Registracija, pravna lica - firme:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('reg_firm')}}</h2>
        </div>

        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Tehnički</h2>
            <hr/>
        </div>
        <div class="col-span-3">
            <h2>Tehnički plaćen gotovinom:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('tech_cash')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Tehnički plaćen čekovima:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('tech_check')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Tehnički plaćen karticom:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('tech_card')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Tehnički pravna lica (fakture):</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('tech_invoice')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Agencija tehnički:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('agency')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Vaučer iznos:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('voucher')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>ADM:</h2>
            <h2 class="text-xl">{{$state->getFormattedAmount('adm')}}</h2>
        </div>
        <div class="col-span-3">
            <h2>Ukupno tehnički:</h2>
            <h2 class="text-xl">{{$state->formatted_tech_total}} din.</h2>
        </div>

        <div class="col-span-12 text-xl mt-3">
            <h2 class="text-2xl">Polise</h2>
            <hr/>
        </div>
        @foreach($state->policies as $policy)
        <div class="col-span-2">
            <h2>Neto polisa {{$policy->insuranceCompany->name}}:</h2>
            <h2 class="text-xl">{{$policy->formatted_policy}} din.</h2>
        </div>
        @endforeach
        <div class="col-span-2">
            <h2>Uplata od osiguravajuće kuće:</h2>
            <h2 class="text-xl">{{$state->policy_percent}}</h2>
        </div>
    </div>
</div>