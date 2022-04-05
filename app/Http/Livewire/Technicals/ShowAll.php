<?php

namespace App\Http\Livewire\Technicals;

use App\Models\InsuranceCompany;
use App\Models\Location;
use App\Models\Technical;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowAll extends Component
{
    use WithPagination;

    private $pagination = 10;
    public $filter = [
        "search" => "",
        "date_from" => "",
        "date_to" => "",
        "location" => "0"
    ];

    public function mount(){
        $this->filter["date_from"] = Carbon::now()->toDateString('YYYY-mm-dd');
        $this->filter["date_to"] = Carbon::now()->toDateString('YYYY-mm-dd');
    }
    
    private function fetch(){
        $technicals = Technical::with('location')->where('reg_number', 'like', '%'.$this->filter["search"].'%');

        if($this->filter["date_from"] != '' && Auth::user()->role_id == 1){
            $technicals = $technicals->where('tech_date', '>=', $this->filter["date_from"]);
        } else {
            $technicals = $technicals->where('tech_date', '>=', Carbon::now()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != '' && Auth::user()->role_id == 1){
            $technicals = $technicals->where('tech_date', '<=', $this->filter["date_to"]);
        } else {
            $technicals = $technicals->where('tech_date', '<=', Carbon::now()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["location"] != 0){
            if(Auth::user()->role_id == 1 || (Auth::user()->role_id == 2 && in_array($this->filter["location"], Auth::user()->locations()->pluck('location_id')->toArray()))){
                $incomes = $technicals->where('location_id', $this->filter["location"]);
            } 
        } else if(Auth::user()->role_id == 2){
            $technicals = $technicals->whereIn('location_id', Auth::user()->locations()->pluck('location_id')->toArray());
        }
        
        return $technicals->latest()->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.technicals.show-all', [
            'technicals' => $this->fetch(),
            'locations' => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
