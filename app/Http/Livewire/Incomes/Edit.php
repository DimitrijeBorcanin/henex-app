<?php

namespace App\Http\Livewire\Incomes;

use App\Models\Income;
use App\Models\IncomeType;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Edit extends Component
{
    public $income;

    public $incomeFields = [
        "income_date" => "",
        "income_type_id" => "0",
        "cash" => "",
        "non_cash" => "",
        "description" => "",
        "excerpt_date" => "",
        "excerpt_status" => ""
    ];

    public function mount(Income $income){
        $this->income = $income;
        $this->setFields();
    }

    public function setFields(){
        $this->incomeFields = [
            "income_date" => $this->income->income_date,
            "income_type_id" => $this->income->income_type_id ?? '',
            "cash" => $this->income->cash ?? '',
            "non_cash" => $this->income->non_cash ?? '',
            "description" => $this->income->description ?? '',
            "excerpt_date" => $this->income->excerpt_date ?? '',
            "excerpt_status" => $this->income->excerpt_status ?? '',
        ];
    }

    public function update(){
        Validator::make($this->incomeFields, [
            'income_date' => ['required', 'date'],
            'cash' => ['required_without_all:non_cash', 'numeric', 'max:1000000'],
            'non_cash' => ['required_without_all:cash', 'numeric', 'max:1000000'],
            'income_type_id' => ['required', 'not_in:0', 'exists:income_types,id'],
            'description' => ['required_if:income_type_id,1', 'string'],
            'excerpt_date' => ['date'],
            'excerpt_status' => ['numeric', 'max:1000000']
        ], [
            'max' => 'Prevelika vrednost.',
            'income_date.required' => 'Datum je obavezan.',
            'income_date.date' => 'Datum nije u dobrom formatu.',
            'income_type_id.required' => 'Vrsta troška je obavezna.',
            'income_type_id.not_in' => 'Vrsta troška nije izabrana.',
            'income_type_id.exists' => 'Vrsta troška ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.',
            'description.required_if' => 'Dodatan opis mora da postoji ako je izabrano OSTALO.',
            'excerpt_date.date' => 'Datum izvoda je u lošem formatu.'
        ])->validate();

        foreach($this->incomeFields as $field => $value){
            if(empty($value)){
                unset($this->incomeFields[$field]);
            }
        }

        $this->income->update($this->incomeFields);

        return redirect()->route('incomes.show', ["income" => $this->income->id]);
    }

    public function render()
    {
        return view('livewire.incomes.edit', [
            'incomeTypes' => IncomeType::all()
        ]);
    }
}
