<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
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
        $checks = new Check();

        if($this->filter["date_from"] != ''){
            $checks = $checks->where('check_date', '>=', $this->filter["date_from"]);
        } else {
            // $checks = $checks->where('check_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $checks = $checks->where('check_date', '<=', $this->filter["date_to"]);
        } else {
            // $checks = $checks->where('check_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        // if($this->filter["location"] != 0){
        //     $checks = $checks->where('location_id', $this->filter["location"]);
        // }

        if($this->filter["location"] != 0){
            if(Auth::user()->role_id == 1 || (Auth::user()->role_id == 2 && in_array($this->filter["location"], Auth::user()->locations()->pluck('location_id')->toArray()))){
                $checks = $checks->where('location_id', $this->filter["location"]);
            } 
        } else if(Auth::user()->role_id == 2){
            $checks = $checks->whereIn('location_id', Auth::user()->locations()->pluck('location_id')->toArray());
        } else if(Auth::user()->role_id == 3){
            $checks = $checks->where('location_id', Auth::user()->location_id)->where('check_date', Carbon::now()->toDateString('YYYY-mm-dd'));
        }
        
        return $checks->orderBy('check_date')->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.checks.show-all', [
            "checks" => $this->fetch(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
