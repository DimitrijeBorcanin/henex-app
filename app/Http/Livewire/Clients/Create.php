<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    public $client = [
        "first_date" => "",
        "full_name" => "",
        "site" => "",
        "recommendation" => "",
        "internet" => "",
        "totems" => "",
        "location_id" => "0"
    ];

    public function store(){
        Validator::make($this->client, [
            'first_date' => ['required', 'date'],
            'full_name' => ['required', 'max:255'],
            'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
                Auth::user()->role_id != 3 ? 'not_in:0' : '',
                Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
                function($att, $val, $fail){
                    if(Auth::user()->role_id == 2 && in_array($val, Auth::user()->locations()->pluck('location_id')->toArray())){
                        $fail('Odabrana je nedozvoljena lokacija.');
                    }
                }]
        ], [
            'first_date.required' => 'Datum je obavezan.',
            'first_date.date' => 'Datum nije u dobrom formatu.',
            'location_id.required' => 'Lokacija je obavezna.',
            'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'full_name.required' => 'Ime i prezime su obavezni.',
            'full_name.max' => 'Ime i prezime su predugački.'
        ])->validate();

        foreach($this->client as $field => $value){
            if(empty($value)){
                unset($this->client[$field]);
            }
        }

        if(Auth::user()->role_id == 3){
            $this->client["location_id"] = Auth::user()->location_id;
        }

        $newClient = Client::create($this->client + ["last_date" => $this->client["first_date"]]);

        return redirect()->route('clients.show', ["client" => $newClient->id]);
    }

    public function render()
    {
        return view('livewire.clients.create', [
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
