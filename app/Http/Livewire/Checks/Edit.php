<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Edit extends Component
{
    public $check;

    public $checkFields = [
        // "check_date" => "",
        "status_start" => "",
        "received" => "",
        "debited" => "",
        "location_id" => "0"
    ];

    public function mount(Check $check){
        $this->check = $check;
        $this->setFields();
    }

    public function setFields(){
        $this->checkFields = [
            // "check_date" => $this->check->check_date,
            "status_start" => $this->check->status_start,
            "received" => $this->check->received,
            "debited" => $this->check->debited,
            // "location_id" => $this->check->location_id
        ];
    }

    public function update(){
        Validator::make($this->checkFields, [
            // 'check_date' => ['required', 'date'],
            'status_start' => ['required', 'numeric', 'max:1000000'],
            'received' => ['required', 'numeric', 'max:1000000'],
            'debited' => ['required', 'numeric', 'max:1000000'],
            // 'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
            //     Auth::user()->role_id != 3 ? 'not_in:0' : '',
            //     Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
            //     function($att, $val, $fail){
            //         if(Auth::user()->role_id == 2 && in_array($val, Auth::user()->locations()->pluck('location_id')->toArray())){
            //             $fail('Odabrana je nedozvoljena lokacija.');
            //         }
            //     }]
        ], [
            'max' => 'Prevelika vrednost.',
            'check_date.required' => 'Datum je obavezan.',
            'check_date.date' => 'Datum nije u dobrom formatu.',
            'numeric' => 'Mora biti broj.',
            'status_start.required' => 'Početno stanje je obavezno.',
            'received.required' => 'Primljeni su obavezni.',
            'debited.required' => 'Razduženi su obavezni.',
            // 'location.required' => 'Morate izabrati lokaciju.',
            // 'location.not_in' => 'Morate izabrati lokaciju.',
            // 'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        // if(Auth::user()->role_id == 3){
        //     $this->checkFields["location_id"] = Auth::user()->location_id;
        // }

        $this->check->update($this->checkFields);

        return redirect()->route('checks.show', ["check" => $this->check->id]);
    }

    public function render()
    {
        return view('livewire.checks.edit', [
            // "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
