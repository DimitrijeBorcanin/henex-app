<?php

namespace App\Http\Livewire\Expenses;

use App\Models\DailyState;
use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Throwable;

class Edit extends Component
{
    public $expense;

    public $expenseFields = [
        "expense_date" => "",
        "expense_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => "",
        // "location_id" => "0"
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
            "location_id" => $this->expense->location_id ?? ''
        ];
    }

    public function update(){
        Validator::make($this->expenseFields, [
            'expense_date' => ['required', 'date'],
            'cash' => ['required_without_all:non_cash', 'numeric', 'max:1000000'],
            'non_cash' => ['required_without_all:cash', 'numeric', 'max:1000000'],
            'expense_type_id' => ['required', 'not_in:0', 'exists:expense_types,id'],
            'description' => ['required_if:expense_type_id,1', 'string'],
            // 'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
            //                 Auth::user()->role_id != 3 ? 'not_in:0' : '',
            //                 Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
            //                 function($att, $val, $fail){
            //                     if(Auth::user()->role_id == 2 && in_array($val, Auth::user()->locations()->pluck('id')->toArray())){
            //                         $fail('Odabrana je nedozvoljena lokacija.');
            //                     }
            //                 }]
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
            // 'location.required' => 'Morate izabrati lokaciju.',
            // 'location.not_in' => 'Morate izabrati lokaciju.',
            // 'location.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        foreach($this->expenseFields as $field => $value){
            if(empty($value)){
                unset($this->expenseFields[$field]);
            }
        }

        // if(Auth::user()->role_id == 3){
        //     $this->expense["location_id"] = Auth::user()->location_id;
        // }

        $state = DailyState::where('state_date', $this->expense["expense_date"])->where('location_id', $this->expense["location_id"])->first();
        if(!$state){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Nije postavljena dnevna tabela za danas za ovu lokaciju!']);
            return;
        }

        try {
            DB::beginTransaction();
            $oldAmount = $this->expense->cash;
            $oldLocation = $this->expense->location_id;
            $oldDate = $this->expense->expense_date;
            $oldType = $this->expense->expense_type_id;
            $this->expense->update($this->expenseFields);
            $oldState = DailyState::where('state_date', $oldDate)->where('location_id', $oldLocation)->first();
            $state = DailyState::where('state_date', $this->expense["expense_date"])->where('location_id', $this->expense["location_id"])->first();
            if($oldType == 1){
                $oldState->updateState('safe_received', 0, $oldAmount);
            } else {
                $oldState->updateState('expenses_cash', 0, $oldAmount);
            }
            if($this->expense->expense_type_id == 1){
                $state->updateState('safe_received', $this->expense["cash"]);
            } else {
                $state->updateState('expenses_cash', $this->expense["cash"]);
            }
            
            DB::commit();
            return redirect()->route('expenses.show', ["expense" => $this->expense->id]);
        } catch (Throwable $e){
            DB::rollBack();
        }   
    }

    public function render()
    {
        return view('livewire.expenses.edit', [
            "expenseTypes" => Auth::user()->role_id == 1 ? ExpenseType::all() : ExpenseType::where('is_admin', '0')->get(),
            // "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
