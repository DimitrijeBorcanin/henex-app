<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public $check = [
        "check_date" => "",
        "status_start" => "",
        "received" => "",
        "debited" => "",
        "location_id" => "0"
    ];

    public function store(){
        Validator::make($this->check, [
            'check_date' => ['required', 'date'],
            'status_start' => ['required', 'numeric', 'max:1000000'],
            'received' => ['required', 'numeric', 'max:1000000'],
            'debited' => ['required', 'numeric', 'max:1000000'],
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
            'check_date.required' => 'Datum je obavezan.',
            'check_date.date' => 'Datum nije u dobrom formatu.',
            'numeric' => 'Mora biti broj.',
            'status_start.required' => 'Početno stanje je obavezno.',
            'received.required' => 'Primljeni su obavezni.',
            'debited.required' => 'Razduženi su obavezni.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        if(Auth::user()->role_id == 3){
            $this->check["location_id"] = Auth::user()->location_id;
        }

        $newCheck = Check::create($this->check);

        return redirect()->route('checks.show', ["check" => $newCheck->id]);
    }

    public function checkLastDay(){
        if(Auth::user()->role_id != 3 && $this->slip["location_id"] == 0){
            return;
        }
        $loc = Auth::user()->role_id != 3 ? $this->slip["location_id"] : Auth::user()->location_id;
        $today = Carbon::now();
        switch($today->dayOfWeek){
            case 1:
                $lastDay = $today->subDays(3);
                break;
            default:
                $lastDay = $today->subDay();
        }
        $lastCheck = Check::where('check_date', $lastDay->toDateString('YYYY-mm-dd'))->where('location_id', $loc)->first();
        if($lastCheck){
            $this->check["status_start"] = $lastCheck->status_end;
        } else {
            $this->check["status_start"] = "";
        }
    }

    public function render()
    {
        return view('livewire.checks.create', [
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
