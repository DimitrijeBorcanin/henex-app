<?php

namespace App\Http\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseType;
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
        "expenseType" => "0",
        "location" => "0"
    ];

    public function mount(){
        $this->filter["date_from"] = Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd');
        $this->filter["date_to"] = Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd');
    }

    private function fetch(){
        $expenses = Expense::with('expenseType');

        if($this->filter["date_from"] != ''){
            $expenses = $expenses->where('expense_date', '>=', $this->filter["date_from"]);
        } else {
            // $expenses = $expenses->where('expense_date', '>=', Carbon::now()->startOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["date_to"] != ''){
            $expenses = $expenses->where('expense_date', '<=', $this->filter["date_to"]);
        } else {
            // $expenses = $expenses->where('expense_date', '<=', Carbon::now()->endOfMonth()->toDateString('YYYY-mm-dd'));
        }

        if($this->filter["expenseType"] != 0){
            $expenses = $expenses->where('expense_type_id', $this->filter["expenseType"]);
        }

        if($this->filter["location"] != 0){
            $expenses = $expenses->where('location_id', $this->filter["location"]);
        }
        
        return $expenses->latest()->paginate($this->pagination);
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.expenses.show-all', [
            'expenses' => $this->fetch(),
            'expenseTypes' => ExpenseType::all(),
            'locations' => Location::all()
        ]);
    }
}