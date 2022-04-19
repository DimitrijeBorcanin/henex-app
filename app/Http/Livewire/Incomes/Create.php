<?php

namespace App\Http\Livewire\Incomes;

use App\Models\DailyState;
use App\Models\Income;
use App\Models\IncomeType;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    public $income = [
        "income_date" => "",
        "income_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => "",
        "excerpt_date" => "",
        "excerpt_status" => "",
        "location_id" => "0"
    ];

    public function store(){
        Validator::make($this->income, [
            'income_date' => [Auth::user()->role_id != 3 ? 'required' : '', 'date'],
            'cash' => ['required_without_all:non_cash', 'numeric', 'max:1000000'],
            'non_cash' => ['required_without_all:cash', 'numeric', 'max:1000000'],
            'income_type_id' => ['required', 'not_in:0', 'exists:income_types,id'],
            'description' => ['required_if:income_type_id,1', 'string'],
            'excerpt_date' => ['date'],
            'excerpt_status' => ['numeric', 'max:1000000'],
            'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
                            Auth::user()->role_id != 3 ? 'not_in:0' : '',
                            Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
                            function($att, $val, $fail){
                                if(Auth::user()->role_id == 2 && in_array($val, Auth::user()->locations()->pluck('location_id')->toArray())){
                                    $fail('Odabrana je nedozvoljena lokacija.');
                                }
                            }]
        ], [
            'max' => 'Prevelika vrednost.',
            'income_date.required' => 'Datum je obavezan.',
            'income_date.date' => 'Datum nije u dobrom formatu.',
            'income_type_id.required' => 'Vrsta prihoda je obavezna.',
            'income_type_id.not_in' => 'Vrsta prihoda nije izabrana.',
            'income_type_id.exists' => 'Vrsta prihoda ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.',
            'description.required_if' => 'Dodatan opis mora da postoji ako je izabrano OSTALO.',
            'excerpt_date.date' => 'Datum izvoda je u lošem formatu.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        foreach($this->income as $field => $value){
            if(empty($value)){
                unset($this->income[$field]);
            }
        }

        if(Auth::user()->role_id == 3){
            $this->income["location_id"] = Auth::user()->location_id;
            $this->income["income_date"] = Carbon::now()->toDateString('YYYY-mm-dd');
        }

        $state = DailyState::where('state_date', $this->income["income_date"])->where('location_id', $this->income["location_id"])->first();
        if(!$state){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Nije postavljena dnevna tabela za danas za ovu lokaciju!']);
            return;
        }

        try {
            DB::beginTransaction();
            $newIncome = Income::create($this->income);
            if($this->income["income_type_id"] != 2 && !empty($this->income["cash"])){
                $state = DailyState::where('state_date', $this->income["income_date"])->where('location_id', $this->income["location_id"])->first();
                $state->updateState('incomes_cash', $this->income["cash"]);
            }
            DB::commit();
            return redirect()->route('incomes.show', ["income" => $newIncome->id]);
        } catch (Throwable $e){
            dd($e->getMessage());
            DB::rollBack();
        }
        
    }

    public function render()
    {
        return view('livewire.incomes.create', [
            "incomeTypes" => IncomeType::orderBy('id', 'desc')->get(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
