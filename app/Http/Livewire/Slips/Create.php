<?php

namespace App\Http\Livewire\Slips;

use App\Models\Location;
use App\Models\Slip;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public $slip = [
        "slip_date" => "",
        "status_start" => "",
        "received" => "",
        "debited" => "",
        "location_id" => "0"
    ];

    public function mount(){
        $this->checkLastDay();
    }

    public function store(){
        Validator::make($this->slip, [
            'status_start' => ['required', 'numeric'],
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
            'numeric' => 'Mora biti broj.',
            'status_start.required' => 'Početno stanje je obavezno.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        if(Auth::user()->role_id == 3){
            $this->state["location_id"] = Auth::user()->location_id;
        }

        $this->state["state_date"] = Carbon::now();

        $exists = Slip::where('location_id', $this->state["location_id"])->where('slip_date', $this->state["slip_date"])->exists();
        if($exists){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Već je postavljeno početno stanje za današnji dan za ovu lokaciju!']);
            return;
        }

        $newSlip = Slip::create($this->slip);

        return redirect()->route('slips.show', ["slip" => $newSlip->id]);
    }

    public function checkLastDay(){
        $today = Carbon::parse($this->slip["slip_date"]);
        switch($today->dayOfWeek){
            case 1:
                $lastDay = $today->subDays(3);
                break;
            default:
                $lastDay = $today->subDay();
        }
        $lastSlip = Slip::where('slip_date', $lastDay->toDateString('YYYY-mm-dd'))->first();
        if($lastSlip){
            $this->slip["status_start"] = $lastSlip->status_end;
        }
    }
    public function render()
    {
        return view('livewire.slips.create', 
        [
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
