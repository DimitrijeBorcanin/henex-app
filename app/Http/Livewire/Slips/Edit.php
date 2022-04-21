<?php

namespace App\Http\Livewire\Slips;

use App\Models\Slip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Edit extends Component
{
    public $slip;

    public $slipFields = [
        "status_start" => "",
        "received" => "",
    ];

    public function mount(Slip $slip){
        $this->slip = $slip;
        $this->setFields();
    }

    public function setFields(){
        $this->slipFields = [
            "status_start" => $this->slip->status_start,
            "received" => $this->slip->received,
        ];
    }

    public function update(){
        Validator::make($this->slipFields, [
            'received' => ['required', 'numeric'],
            'status_start' => ['required', 'numeric']
        ], [
            'max' => 'Prevelika vrednost.',
            'numeric' => 'Mora biti broj.',
            'status_start.required' => 'Početno stanje je obavezno.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.',
            'received.required' => 'Morate uneti vrednost za primljeno.'
        ])->validate();

        // if(Auth::user()->role_id == 3){
        //     $this->checkFields["location_id"] = Auth::user()->location_id;
        // }

        $this->slip->update($this->slipFields);

        return redirect()->route('slips.show', ["slip" => $this->slip->id]);
    }

    public function render()
    {
        return view('livewire.slips.edit');
    }
}
