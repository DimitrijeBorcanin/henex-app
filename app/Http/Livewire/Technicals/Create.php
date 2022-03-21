<?php

namespace App\Http\Livewire\Technicals;

use App\Models\InsuranceCompany;
use App\Models\Location;
use App\Models\Technical;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Create extends Component
{

    public $technical = [
        "reg_number" => "",
        "reg_cash" => "",
        "reg_check" => "",
        "reg_card" => "",
        "reg_firm" => "",
        "tech_cash" => "",
        "tech_check" => "",
        "tech_card" => "",
        "tech_invoice" => "",
        "agency" => "",
        "voucher" => "",
        "adm" => "",
        "policy" => "",
        "insurance_company_id" => "0",
        "location_id" => "0",
    ];

    public function store(){
        Validator::make($this->technical, [
            'reg_number' => ['required', 'string', 'max:255'],
            'reg_cash' => ['required_without_all:reg_check,reg_card,reg_firm', 'numeric', 'max:1000000'],
            'reg_check' => ['required_without_all:reg_cash,reg_card,reg_firm', 'numeric', 'max:1000000'],
            'reg_card' => ['required_without_all:reg_check,reg_cash,reg_firm', 'numeric', 'max:1000000'],
            'reg_firm' => ['required_without_all:reg_check,reg_card,reg_cash', 'numeric', 'max:1000000'],
            'tech_cash' => ['required_without_all:tech_check,tech_card,tech_invoice', 'numeric', 'max:1000000'],
            'tech_check' => ['required_without_all:tech_cash,tech_card,tech_invoice', 'numeric', 'max:1000000'],
            'tech_card' => ['required_without_all:tech_check,tech_cash,tech_invoice', 'numeric', 'max:1000000'],
            'tech_invoice' => ['required_without_all:tech_check,tech_cash,tech_card', 'numeric', 'max:1000000'],
            'agency' => ['numeric', 'max:1000000'],
            'voucher' => ['numeric', 'max:1000000'],
            'adm' => ['numeric', 'max:1000000'],
            'insurance_company_id' => ['required', 'not_in:0', 'exists:insurance_companies,id'],
            'location_id' => [Auth::user()->role_id == 1 ? 'required' : '', 'not_in:0', 'exists:locations,id']
        ], [
            'max' => 'Prevelika vrednost.',
            'reg_number.required' => 'Registarski broj je obavezan.',
            'reg_number.max' => 'Registarski broj je predugačak.',
            'insurance_company_id.required' => 'Osiguranje je obavezno.',
            'insurance_company_id.not_in' => 'Osiguranje nije izabrano.',
            'insurance_company_id.exists' => 'Osiguranje ne postoji u bazi.',
            'location_id.required' => 'Lokacija je obavezna.',
            'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.'
        ])->validate();

        foreach($this->technical as $field => $value){
            if(empty($value)){
                unset($this->technical[$field]);
            }
        }

        if(Auth::user()->role_id != 1){
            unset($this->technical['location_id']);
        }

        $this->technical['tech_date'] = Carbon::now()->format('Y-m-d');

        $newTechnical = Technical::create($this->technical);

        return redirect()->route('technicals.show', ["technical" => $newTechnical->id]);
    }

    public function render()
    {
        return view('livewire.technicals.create', [
            'companies' => InsuranceCompany::all(),
            'locations' => Location::all()
        ]);
    }
}
