<?php

namespace App\Http\Livewire\Technicals;

use App\Models\InsuranceCompany;
use App\Models\Location;
use App\Models\Technical;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;

class Edit extends Component
{
    public $technical;

    public $technicalFields = [
        "tech_date" => "",
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
        "location_id" => "0"
    ];

    public function mount(Technical $technical){
        $this->technical = $technical;
        $this->setFields();
    }

    public function setFields(){
        $this->technicalFields = [
            "tech_date" => $this->technical->tech_date,
            "reg_number" => $this->technical->reg_number ?? '',
            "reg_cash" => $this->technical->reg_cash ?? '',
            "reg_check" => $this->technical->reg_check ?? '',
            "reg_card" => $this->technical->reg_card ?? '',
            "reg_firm" => $this->technical->reg_firm ?? '',
            "tech_cash" => $this->technical->tech_cash ?? '',
            "tech_check" => $this->technical->tech_check ?? '',
            "tech_card" => $this->technical->tech_card ?? '',
            "tech_invoice" => $this->technical->tech_invoice ?? '',
            "agency" => $this->technical->agency ?? '',
            "voucher" => $this->technical->voucher ?? '',
            "adm" => $this->technical->adm ?? '',
            "policy" => $this->technical->policy,
            "insurance_company_id" => $this->technical->insurance_company_id,
            "location_id" => $this->technical->location_id,
        ];
    }

    public function update(){
        Validator::make($this->technicalFields, [
            'reg_number' => ['required', 'string', 'max:255'],
            'tech_date' => ['required', 'date'],
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
            'insurance_company_id' => ['exists:insurance_companies,id'],
            'policy' => ['numeric', 'max:1000000'],
            'location_id' => ['required', 'not_in:0', 'exists:locations,id']
        ], [
            'max' => 'Prevelika vrednost.',
            'tech_date.required' => 'Datum je obavezan.',
            'tech_date.date' => 'Datum je u lošem formatu.',
            'reg_number.required' => 'Registarski broj je obavezan.',
            'reg_number.max' => 'Registarski broj je predugačak.',
            'insurance_company_id.required' => 'Osiguranje je obavezno.',
            'insurance_company_id.not_in' => 'Osiguranje nije izabrano.',
            'insurance_company_id.exists' => 'Osiguranje ne postoji u bazi.',
            // 'location_id.required' => 'Lokacija je obavezna.',
            // 'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.'
        ])->validate();

        foreach($this->technicalFields as $field => $value){
            if(empty($value)){
                $this->technicalFields[$field] = null;
            }
        }

        $this->technical->update($this->technicalFields);

        return redirect()->route('technicals.show', ["technical" => $this->technical->id]);
    }

    public function render()
    {
        return view('livewire.technicals.edit', [
            'companies' => InsuranceCompany::all(),
            'locations' => Location::all()
        ]);
    }
}
