<?php

namespace App\Http\Livewire\Expenses;

use App\Models\DailyState;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Create extends Component
{
    public $expense = [
        "expense_date" => "",
        "expense_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => "",
        "location_id" => "0"
    ];

    public function store(){
        Validator::make($this->expense, [
            'expense_date' => ['required', 'date'],
            'cash' => ['required_without_all:non_cash', 'numeric', 'max:1000000'],
            'non_cash' => ['required_without_all:cash', 'numeric', 'max:1000000'],
            'expense_type_id' => ['required', 'not_in:0', 'exists:expense_types,id'],
            'description' => ['required_if:expense_type_id,1', 'string'],
            'location_id' => ['required', 'not_in:0', 'exists:locations,id']
        ], [
            'max' => 'Prevelika vrednost.',
            'expense_date.required' => 'Datum je obavezan.',
            'expense_date.date' => 'Datum nije u dobrom formatu.',
            'expense_type_id.required' => 'Vrsta troška je obavezna.',
            'expense_type_id.not_in' => 'Vrsta troška nije izabrana.',
            'expense_type_id.exists' => 'Vrsta troška ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.',
            'description.required_if' => 'Dodatan opis mora da postoji ako je izabrano OSTALO.',
            'location.required' => 'Morate izabrati lokaciju.',
            'location.not_in' => 'Morate izabrati lokaciju.',
            'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        foreach($this->expense as $field => $value){
            if(empty($value)){
                unset($this->expense[$field]);
            }
        }

        try {
            DB::beginTransaction();
            $newExpense = Expense::create($this->expense);
            $state = DailyState::where('state_date', $this->expense["expense_date"])->where('location_id', $this->expense["location_id"])->first();
            $state->updateState('expenses_cash', $this->expense["cash"]);
            DB::commit();
            return redirect()->route('expenses.show', ["expense" => $newExpense->id]);
        } catch (Throwable $e){
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.expenses.create', [
            "expenseTypes" => ExpenseType::all(),
            "locations" => Location::all()
        ]);
    }
}
