<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class NotReturned extends Component
{
    use WithPagination;
    
    private $pagination = 1;
    public $filterNotReturned = [
        "search" => "",
        "date_from" => "",
        "date_to" => "",
        "location" => "0"
    ];

    private function fetchNotReturned(){
        $clients = Client::where('full_name', 'like', '%'.$this->filterNotReturned["search"].'%')->where('last_date', '<', Carbon::now()->subYear()->toDateString('YYYY-mm-dd'));

        if($this->filterNotReturned["date_from"] != ''){
            $clients = $clients->where('income_date', '>=', $this->filterNotReturned["date_from"]);
        }

        if($this->filterNotReturned["date_to"] != ''){
            $clients = $clients->where('income_date', '<=', $this->filterNotReturned["date_to"]);
        }

        if($this->filterNotReturned["location"] != 0){
            $clients = $clients->where('location_id', $this->filterNotReturned["location"]);
        }
        
        return $clients->latest()->paginate($this->pagination);
    }

    public function updatingFilterNotReturned(){
        $this->resetPage();
    }

    public function getQueryString()
    {
        return [];
    }

    public function render()
    {
        return view('livewire.clients.not-returned', [
            "notReturned" => $this->fetchNotReturned(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
