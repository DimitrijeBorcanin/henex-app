<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;
    
    private $pagination = 2;
    public $filterNew = [
        "search" => "",
        "date_from" => "",
        "date_to" => "",
        "location" => "0"
    ];

    private function fetchNew(){
        $clients = Client::where('full_name', 'like', '%'.$this->filterNew["search"].'%')->whereRaw('first_date = last_date');

        if($this->filterNew["date_from"] != ''){
            $clients = $clients->where('income_date', '>=', $this->filterNew["date_from"]);
        }

        if($this->filterNew["date_to"] != ''){
            $clients = $clients->where('income_date', '<=', $this->filterNew["date_to"]);
        }

        if($this->filterNew["location"] != 0){
            $clients = $clients->where('location_id', $this->filterNew["location"]);
        }
        return $clients->latest()->paginate($this->pagination);
    }

    public function updatingFilterNew(){
        $this->resetPage();
    }

    public function getQueryString()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.clients.show-all', [
            "newClients" => $this->fetchNew(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
