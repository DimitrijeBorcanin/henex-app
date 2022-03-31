<?php

namespace App\Http\Livewire\DailyStates;

use App\Models\DailyState;
use App\Models\Location;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;
    
    private $pagination = 10;
    public $filter = [
        "date_from" => "",
        "date_to" => "",
        "location" => "0"
    ];

    public function mount(){
        $this->filter["date_from"] = Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd');
        $this->filter["date_to"] = Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd');
    }

    private function fetch(){
        $checks = new DailyState();

        if($this->filter["date_from"] != ''){
            $checks = $checks->where('state_date', '>=', $this->filter["date_from"]);
        } else {
            // $checks = $checks->where('state_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $checks = $checks->where('state_date', '<=', $this->filter["date_to"]);
        } else {
            // $checks = $checks->where('state_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["location"] != 0){
            $checks = $checks->where('location_id', $this->filter["location"]);
        }
        
        return $checks->orderBy('state_date', 'desc')->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.daily-states.show-all', [
            "states" => $this->fetch(),
            "locations" => Location::all()
        ]);
    }
}
