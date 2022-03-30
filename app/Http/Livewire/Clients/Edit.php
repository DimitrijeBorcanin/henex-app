<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Edit extends Component
{
    public $client;

    public $clientFields = [
        "first_date" => "",
        "full_name" => "",
        "site" => "",
        "recommendation" => "",
        "internet" => "",
        "totems" => "",
        "location_id" => "0",
        "last_date" => "",
        "reason" => ""
    ];

    public function mount(Client $client){
        $this->client = $client;
        $this->setFields();
    }

    public function setFields(){
        $this->clientFields = [
            "first_date" => $this->client->first_date ?? '',
            "full_name" => $this->client->full_name ?? '',
            "site" => $this->client->site ?? '',
            "recommendation" => $this->client->recommendation ?? '',
            "internet" => $this->client->internet ?? '',
            "totems" => $this->client->totems ?? '',
            "location_id" => $this->client->location_id ?? '',
            "last_date" => $this->client->last_date ?? '',
            "reason" => $this->client->reason ?? ''
        ];
    }

    public function update(){
        Validator::make($this->clientFields, [
            'first_date' => ['required', 'date'],
            'full_name' => ['required', 'max:255'],
            'location_id' => [Auth::user()->role_id == 1 ? 'required' : '', 'not_in:0', 'exists:locations,id'],
            'last_date' => ['required', 'date', 'after_or_equal:first_date'],
            'reason' => ['max:255']
        ], [
            'first_date.required' => 'Datum prvog dolaska je obavezan.',
            'first_date.date' => 'Datum prvog dolaska nije u dobrom formatu.',
            'last_date.required' => 'Datum poslednjeg dolaska je obavezan.',
            'last_date.date' => 'Datum poslednjeg dolaska nije u dobrom formatu.',
            'last_date.after_or_equal' => 'Datum poslednjeg dolaska mora biti jednak ili posle datuma prvog dolaska.',
            'location_id.required' => 'Lokacija je obavezna.',
            'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'full_name.required' => 'Ime i prezime su obavezni.',
            'full_name.max' => 'Ime i prezime su predugački.',
            'reason.max' => 'Razlog je predugačak.'
        ])->validate();

        foreach($this->clientFields as $field => $value){
            if(empty($value)){
                unset($this->clientFields[$field]);
            }
        }

        if(Auth::user()->role_id != 1){
            $this->client["location_id"] = Auth::user()->location_id;
        }

        $this->client->update($this->clientFields);

        return redirect()->route('clients.show', ["client" => $this->client->id]);
    }

    public function render()
    {
        return view('livewire.clients.edit', [
            "locations" => Location::all()
        ]);
    }
}
