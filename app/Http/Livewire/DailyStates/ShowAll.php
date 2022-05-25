<?php

namespace App\Http\Livewire\DailyStates;

use App\Models\DailyState;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
        $states = new DailyState();

        if($this->filter["date_from"] != ''){
            $states = $states->where('state_date', '>=', $this->filter["date_from"]);
        } else {
            // $states = $states->where('state_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $states = $states->where('state_date', '<=', $this->filter["date_to"]);
        } else {
            // $states = $states->where('state_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        // if($this->filter["location"] != 0){
        //     $states = $states->where('location_id', $this->filter["location"]);
        // }

        if($this->filter["location"] != 0){
            if(Auth::user()->role_id == 1 || (Auth::user()->role_id == 2 && in_array($this->filter["location"], Auth::user()->locations()->pluck('location_id')->toArray()))){
                $states = $states->where('location_id', $this->filter["location"]);
            } 
        } else if(Auth::user()->role_id == 2){
            $states = $states->whereIn('location_id', Auth::user()->locations()->pluck('location_id')->toArray());
        }
        
        return $states->orderBy('state_date', 'desc')->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.daily-states.show-all', [
            "states" => $this->fetch(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
