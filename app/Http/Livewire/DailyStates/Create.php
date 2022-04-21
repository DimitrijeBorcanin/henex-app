<?php

namespace App\Http\Livewire\DailyStates;

use App\Models\DailyState;
use App\Models\InsuranceCompany;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    public $state = [
        "register_start" => "",
        "safe_start" => "",
        "location_id" => "0",
    ];

    public function mount(){
        $this->getPreviousState();
    }

    public function store(){
        Validator::make($this->state, [
            'register_start' => ['required', 'numeric'],
            'safe_start' => ['required', 'numeric'],
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
            'register_start.required' => 'Stanje kase na početku dana je obavezno.',
            'safe_start.required' => 'Stanje sefa na početku dana je obavezno.',
            'numeric' => 'Mora biti broj.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        if(Auth::user()->role_id == 3){
            $this->state["location_id"] = Auth::user()->location_id;
        }

        $this->state["state_date"] = Carbon::now();

        $exists = DailyState::where('location_id', $this->state["location_id"])->where('state_date', $this->state["state_date"])->exists();
        if($exists){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Već je postavljeno početno stanje za današnji dan za ovu lokaciju!']);
            return;
        }
        try {
            DB::beginTransaction();
            $insuranceCompanies = InsuranceCompany::all();
            $newState = DailyState::create($this->state);
            foreach($insuranceCompanies as $ic){
                $newState->policies()->create(["daily_state_id" => $newState->id, "insurance_company_id" => $ic->id]);
            }
            DB::commit();
            return redirect()->route('daily-states.show', ["state" => $newState->id]);
        } catch (Throwable $e){
            DB::rollBack();
            $this->dispatchBrowserEvent('error', ['message' => 'Došlo je do greške!']);
        }

    }

    public function getPreviousState(){
        if(Auth::user()->role_id != 3 && $this->state["location_id"] == 0){
            return;
        }
        $loc = Auth::user()->role_id != 3 ? $this->state["location_id"] : Auth::user()->location_id;
        $today = Carbon::now();
        switch($today->dayOfWeek){
            case 1:
                $lastDay = $today->subDays(3);
                break;
            default:
                $lastDay = $today->subDay();
        }
        $previousState = DailyState::where('state_date', $lastDay->toDateString('YYYY-mm-dd'))->where('location_id', $loc)->first();
        if($previousState){
            $this->state["register_start"] = $previousState->register_end;
            $this->state["safe_start"] = $previousState->safe_end;
        } else {
            $this->state["register_start"] = "";
            $this->state["safe_start"] = "";
        }
    }

    public function render()
    {
        return view('livewire.daily-states.create', [
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
