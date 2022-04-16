<?php

namespace App\Http\Livewire\Slips;

use App\Models\Location;
use App\Models\Slip;
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
        $slips = new Slip();

        if($this->filter["date_from"] != ''){
            $slips = $slips->where('slip_date', '>=', $this->filter["date_from"]);
        } else {
            // $slips = $slips->where('slip_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $slips = $slips->where('slip_date', '<=', $this->filter["date_to"]);
        } else {
            // $slips = $slips->where('slip_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["location"] != 0){
            $slips = $slips->where('location_id', $this->filter["location"]);
        }
        
        return $slips->orderBy('slip_date')->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.slips.show-all', [
            "slips" => $this->fetch(),
            "locations" => Location::all()
        ]);
    }
}
