<?php

namespace App\Http\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseType;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Create extends Component
{
    public $expense = [
        "expense_date" => "",
        "expense_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => ""
    ];

    public function store(){
        Validator::make($this->expense, [
            'expense_date' => ['required', 'date'],
            'cash' => ['required_without_all:non_cash', 'numeric', 'max:1000000'],
            'non_cash' => ['required_without_all:cash', 'numeric', 'max:1000000'],
            'expense_type_id' => ['required', 'not_in:0', 'exists:expense_types,id'],
            'description' => ['required_if:expense_type_id,1', 'string']
        ], [
            'max' => 'Prevelika vrednost.',
            'expense_date.required' => 'Datum je obavezan.',
            'expense_date.date' => 'Datum nije u dobrom formatu.',
            'expense_type_id.required' => 'Vrsta troška je obavezna.',
            'expense_type_id.not_in' => 'Vrsta troška nije izabrana.',
            'expense_type_id.exists' => 'Vrsta troška ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.',
            'description.required_if' => 'Dodatan opis mora da postoji ako je izabrano OSTALO.' 
        ])->validate();

        foreach($this->expense as $field => $value){
            if(empty($value)){
                unset($this->expense[$field]);
            }
        }

        $newExpense = Expense::create($this->expense);

        return redirect()->route('expenses.show', ["expense" => $newExpense->id]);
    }

    public function render()
    {
        return view('livewire.expenses.create', [
            "expenseTypes" => ExpenseType::all()
        ]);
    }
}
