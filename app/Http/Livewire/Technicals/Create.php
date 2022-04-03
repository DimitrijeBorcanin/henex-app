<?php

namespace App\Http\Livewire\Technicals;

use App\Models\DailyState;
use App\Models\InsuranceCompany;
use App\Models\Location;
use App\Models\Technical;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Throwable;

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
        "insurance_company_id" => "",
        "location_id" => "0",
    ];

    public function store(){

        Validator::make($this->technical, [
            'reg_number' => ['required', 'string', 'max:255'],
            'reg_cash' => ['required_without_all:reg_check,reg_card,reg_firm', 'numeric', 'max:1000000'],
            'reg_check' => ['required_without_all:reg_cash,reg_card,reg_firm', 'numeric', 'max:1000000'],
            'reg_card' => ['required_without_all:reg_check,reg_cash,reg_firm', 'numeric', 'max:1000000'],
            'reg_firm' => ['required_without_all:reg_check,reg_card,reg_cash', 'numeric', 'max:1000000'],
            // 'tech_cash' => ['required_without_all:tech_check,tech_card,tech_invoice', 'numeric', 'max:1000000'],
            // 'tech_check' => ['required_without_all:tech_cash,tech_card,tech_invoice', 'numeric', 'max:1000000'],
            // 'tech_card' => ['required_without_all:tech_check,tech_cash,tech_invoice', 'numeric', 'max:1000000'],
            // 'tech_invoice' => ['required_without_all:tech_check,tech_cash,tech_card', 'numeric', 'max:1000000'],
            'tech_cash' => ['numeric', 'max:1000000'],
            'tech_check' => ['numeric', 'max:1000000'],
            'tech_card' => ['numeric', 'max:1000000'],
            'tech_invoice' => ['numeric', 'max:1000000'],
            'agency' => ['numeric', 'max:1000000'],
            'voucher' => ['numeric', 'max:1000000'],
            'adm' => ['numeric', 'max:1000000'],
            'insurance_company_id' => ['exists:insurance_companies,id'],
            'policy' => ['numeric', 'max:1000000'],
            'location_id' => [Auth::user()->role_id == 1 ? 'required' : '', 
                                Auth::user()->role_id == 1 ? 'not_in:0' : '',
                                Auth::user()->role_id == 1 ? 'exists:locations,id' : '']
        ], [
            'max' => 'Prevelika vrednost.',
            'reg_number.required' => 'Registarski broj je obavezan.',
            'reg_number.max' => 'Registarski broj je predugačak.',
            'insurance_company_id.required' => 'Osiguranje je obavezno.',
            'insurance_company_id.not_in' => 'Osiguranje nije izabrano.',
            'insurance_company_id.exists' => 'Osiguranje ne postoji u bazi.',
            // 'location_id.required' => 'Lokacija je obavezna.',
            // 'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.',
        ])->validate();

        foreach($this->technical as $field => $value){
            if(empty($value)){
                $this->technical[$field] = null;
            }
        }

        if(Auth::user()->role_id != 1){
            $this->technical['location_id'] = Auth::user()->location_id;
        }

        $this->technical['tech_date'] = Carbon::now()->format('Y-m-d');

        try {
            DB::beginTransaction();
            $newTechnical = Technical::create($this->technical);

            $state = DailyState::where('state_date', $this->technical["tech_date"])->where('location_id', $this->technical["location_id"])->first();

            $state->updateState('reg_cash', $this->technical["reg_cash"]);
            $state->updateState('reg_check', $this->technical["reg_check"]);
            $state->updateState('reg_card', $this->technical["reg_card"]);
            $state->updateState('reg_firm', $this->technical["reg_firm"]);
            $state->updateState('tech_cash', $this->technical["tech_cash"]);
            $state->updateState('tech_check', $this->technical["tech_check"]);
            $state->updateState('tech_card', $this->technical["tech_card"]);
            $state->updateState('tech_invoice', $this->technical["tech_invoice"]);
            $state->updateState('agency', $this->technical["agency"]);
            $state->updateState('voucher', $this->technical["voucher"]);
            $state->updateState('adm', $this->technical["adm"]);

            $state->updatePolicy($this->technical["insurance_company_id"], $this->technical["policy"]);

            if($this->technical["voucher"] && $this->technical["voucher"] > 0){
                $state->voucher_no = $state->voucher_no + 1;
                $state->save();
            }

            DB::commit();
            return redirect()->route('technicals.show', ["technical" => $newTechnical->id]);
        } catch (Throwable $e){
            DB::rollBack();
            dd($e);
            $this->dispatchBrowserEvent('success', ['message' => 'Došlo je do greške!']);
        }
        
    }

    public function render()
    {
        return view('livewire.technicals.create', [
            'companies' => InsuranceCompany::all(),
            'locations' => Location::all()
        ]);
    }
}
