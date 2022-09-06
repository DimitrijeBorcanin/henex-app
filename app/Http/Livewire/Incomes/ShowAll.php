<?php

namespace App\Http\Livewire\Incomes;

use App\Models\Income;
use App\Models\IncomeType;
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
        "incomeType" => "0",
        "location" => "0"
    ];

    public function mount(){
        $this->filter["date_from"] = Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd');
        $this->filter["date_to"] = Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd');
    }

    private function fetch(){
        // if(Auth::user()->role_id == 3){
        //     return [];
        // }
        
        $incomes = Income::with('incomeType');

        if($this->filter["date_from"] != '' && Auth::user()->role_id != 3){
            $incomes = $incomes->where('income_date', '>=', $this->filter["date_from"]);
        } else {
            // $incomes = $incomes->where('income_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != '' && Auth::user()->role_id != 3){
            $incomes = $incomes->where('income_date', '<=', $this->filter["date_to"]);
        } else {
            // $incomes = $incomes->where('income_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["incomeType"] != 0){
            $incomes = $incomes->where('income_type_id', $this->filter["incomeType"]);
        }

        if($this->filter["location"] != 0){
            if(Auth::user()->role_id == 1 || (Auth::user()->role_id == 2 && in_array($this->filter["location"], Auth::user()->locations()->pluck('location_id')->toArray()))){
                $incomes = $incomes->where('location_id', $this->filter["location"]);
            } 
        } else if(Auth::user()->role_id == 2){
            $incomes = $incomes->whereIn('location_id', Auth::user()->locations()->pluck('location_id')->toArray());
        } else if(Auth::user()->role_id == 3){
            $income = $incomes->where('location_id', Auth::user()->location_id)->where('income_date', Carbon::now()->toDateString('YYYY-mm-dd'));
        }
        
        return $incomes->latest()->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.incomes.show-all', [
            'incomes' => $this->fetch(),
            'incomeTypes' => IncomeType::all(),
            'locations' => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
