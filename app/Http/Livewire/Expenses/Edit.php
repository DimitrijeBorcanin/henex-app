<?php

namespace App\Http\Livewire\Expenses;

use App\Models\Expense;
use App\Models\ExpenseType;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Edit extends Component
{
    public $expense;

    public $expenseFields = [
        "expense_date" => "",
        "expense_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => ""
    ];

    public function mount(Expense $expense){
        $this->expense = $expense;
        $this->setFields();
    }

    public function setFields(){
        $this->expenseFields = [
            "expense_date" => $this->expense->expense_date,
            "expense_type_id" => $this->expense->expense_type_id ?? '',
            "cash" => $this->expense->cash ?? '',
            "non_cash" => $this->expense->non_cash ?? '',
            "description" => $this->expense->description ?? '',
        ];
    }

    public function update(){
        Validator::make($this->expenseFields, [
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

        foreach($this->expenseFields as $field => $value){
            if(empty($value)){
                unset($this->expenseFields[$field]);
            }
        }

        $this->expense->update($this->expenseFields);

        return redirect()->route('expenses.show', ["expense" => $this->expense->id]);
    }

    public function render()
    {
        return view('livewire.expenses.edit', [
            "expenseTypes" => ExpenseType::all()
        ]);
    }
}
