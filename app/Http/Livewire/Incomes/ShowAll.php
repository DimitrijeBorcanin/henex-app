<?php

namespace App\Http\Livewire\Incomes;

use App\Models\Income;
use App\Models\IncomeType;
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
        "incomeType" => "0"
    ];

    public function mount(){
        $this->filter["date_from"] = Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd');
        $this->filter["date_to"] = Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd');
    }

    private function fetch(){
        $incomes = Income::with('incomeType');

        if($this->filter["date_from"] != ''){
            $incomes = $incomes->where('income_date', '>=', $this->filter["date_from"]);
        } else {
            // $incomes = $incomes->where('income_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $incomes = $incomes->where('income_date', '<=', $this->filter["date_to"]);
        } else {
            // $incomes = $incomes->where('income_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["incomeType"] != 0){
            $incomes = $incomes->where('income_type_id', $this->filter["incomeType"]);
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
            'incomeTypes' => IncomeType::all()
        ]);
    }
}
