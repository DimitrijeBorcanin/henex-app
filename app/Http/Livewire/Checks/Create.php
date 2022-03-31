<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
use App\Models\Location;
use Carbon\Carbon;
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
            'location_id' => ['required', 'not_in:0', 'exists:locations,id']
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

        $newCheck = Check::create($this->check);

        return redirect()->route('checks.show', ["check" => $newCheck->id]);
    }

    public function checkLastDay(){
        $today = Carbon::parse($this->check["check_date"]);
        switch($today->dayOfWeek){
            case 1:
                $lastDay = $today->subDays(3);
                break;
            default:
                $lastDay = $today->subDay();
        }
        $lastCheck = Check::where('check_date', $lastDay->toDateString('YYYY-mm-dd'))->first();
        if($lastCheck){
            $this->check["status_start"] = $lastCheck->status_end;
        }
    }

    public function render()
    {
        return view('livewire.checks.create', [
            "locations" => Location::all()
        ]);
    }
}
