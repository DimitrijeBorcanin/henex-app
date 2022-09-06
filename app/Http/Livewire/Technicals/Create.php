<?php

namespace App\Http\Livewire\Technicals;

use App\Models\Check;
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
        "adm_non_cash" => "",
        "policy" => "",
        "policy_check" => "",
        "insurance_company_id" => "",
        "location_id" => "0",
        "returning" => false,
        "total" => ""
    ];

    public $autofillPayment = "";

    public function store(){
        
        if($this->technical["insurance_company_id"] == "0"){
            $this->technical["insurance_company_id"] == null;
        }

        Validator::make($this->technical, [
            'reg_number' => ['string', 'max:255'],
            'reg_cash' => ['numeric'],
            'reg_check' => ['numeric'],
            'reg_card' => ['numeric'],
            'reg_firm' => ['numeric'],
            // 'reg_cash' => ['required_without_all:reg_check,reg_card,reg_firm,tech_cash,tech_check,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'reg_check' => ['required_without_all:reg_cash,reg_card,reg_firm,tech_cash,tech_check,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'reg_card' => ['required_without_all:reg_check,reg_cash,reg_firm,tech_cash,tech_check,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'reg_firm' => ['required_without_all:reg_check,reg_card,reg_cash,tech_cash,tech_check,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'tech_cash' => ['required_without_all:tech_check,tech_card,tech_invoice', 'numeric'],
            // 'tech_check' => ['required_without_all:tech_cash,tech_card,tech_invoice', 'numeric'],
            // 'tech_card' => ['required_without_all:tech_check,tech_cash,tech_invoice', 'numeric'],
            // 'tech_invoice' => ['required_without_all:tech_check,tech_cash,tech_card', 'numeric'],
            'tech_cash' => ['numeric'],
            'tech_check' => ['numeric'],
            'tech_card' => ['numeric'],
            'tech_invoice' => ['numeric'],
            'agency' => ['numeric'],
            'voucher' => ['numeric'],
            'adm' => ['numeric'],
            'adm_non_cash' => ['numeric'],
            // 'tech_cash' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'tech_check' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_cash,tech_card,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'tech_card' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_cash,tech_invoice,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'tech_invoice' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_cash,agency,voucher,adm,adm_non_cash', 'numeric'],
            // 'agency' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_invoice,tech_cash,voucher,adm,adm_non_cash', 'numeric'],
            // 'voucher' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_invoice,tech_cash,agency,adm,adm_non_cash', 'numeric'],
            // 'adm' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_invoice,tech_cash,voucher,agency,adm_non_cash', 'numeric'],
            // 'adm_non_cash' => ['required_without_all:reg_check,reg_card,reg_firm,reg_cash,tech_check,tech_card,tech_invoice,tech_cash,voucher,adm,agency', 'numeric'],
            'insurance_company_id' => ['exists:insurance_companies,id'],
            'policy' => ['numeric'],
            'policy_check' => ['numeric'],
            'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
                            Auth::user()->role_id != 3 ? 'not_in:0' : '',
                            Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
                            function($att, $val, $fail){
                                if(Auth::user()->role_id == 2 && !in_array($val, Auth::user()->locations()->pluck('location_id')->toArray())){
                                    $fail('Odabrana je nedozvoljena lokacija.');
                                }
                            }],
            'returning' => [],
            'total' => ['numeric']
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
            if(empty($value) && $field != "returning"){
                $this->technical[$field] = null;
            }
        }

        if(Auth::user()->role_id == 3){
            $this->technical['location_id'] = Auth::user()->location_id;
        }

        $this->technical['tech_date'] = Carbon::now()->format('Y-m-d');

        $state = DailyState::where('state_date', $this->technical["tech_date"])->where('location_id', $this->technical["location_id"])->first();
        if(!$state){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Nije postavljena dnevna tabela za danas za ovu lokaciju!']);
            return;
        }

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
            $state->updateState('adm_non_cash', $this->technical["adm_non_cash"]);

            $state->updatePolicy($this->technical["insurance_company_id"], $this->technical["policy"]);

            if($this->technical["voucher"] && $this->technical["voucher"] > 0){
                $state->voucher_no = $state->voucher_no + 1;
                $state->save();
            }

            if(!$this->technical["returning"]){
                    $state->technical_no = $state->technical_no + 1;
                    $state->save();
            }

            $check = Check::where('check_date', $this->technical["tech_date"])->where('location_id', $this->technical["location_id"])->first();
            if($this->technical["tech_check"] && $this->technical["tech_check"] > 0){
                $check->updateState('received', $this->technical["tech_check"]);
            }
            if($this->technical["reg_check"] && $this->technical["reg_check"] > 0){
                $check->updateState('received', $this->technical["reg_check"]);
            }
            if($this->technical["policy_check"] && $this->technical["policy_check"] > 0){
                $check->updateState('debited', $this->technical["policy_check"]);
            }

            DB::commit();
            return redirect()->route('technicals.show', ["technical" => $newTechnical->id]);
        } catch (Throwable $e){
            DB::rollBack();
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Došlo je do greške!']);
        }
        
    }

    public function calculateDifference(){
        $this->technical["reg_cash"] = "";
        $this->technical["reg_check"] = "";
        $this->technical["reg_card"] = "";
        $this->technical["reg_firm"] = "";

        $sumTech = (empty($this->technical["tech_cash"]) ? 0 : $this->technical["tech_cash"])
                + (empty($this->technical["tech_card"]) ? 0 : $this->technical["tech_card"])
                + (empty($this->technical["tech_check"]) ? 0 : $this->technical["tech_check"])
                + (empty($this->technical["voucher"]) ? 0 : $this->technical["voucher"])
                + (empty($this->technical["adm"]) ? 0 : $this->technical["adm"])
                + (empty($this->technical["adm_non_cash"]) ? 0 : $this->technical["adm_non_cash"])
                + (empty($this->technical["agency"]) ? 0 : $this->technical["agency"])
                + (empty($this->technical["tech_invoice"]) ? 0 : $this->technical["tech_invoice"]);

        if($sumTech && $sumTech > 0 && !empty($this->autofillPayment) && $this->technical["total"] && $this->technical["total"] > 0){
            $this->technical[$this->autofillPayment] = $this->technical["total"] - $sumTech;
        }
    }

    public function render()
    {
        return view('livewire.technicals.create', [
            'companies' => InsuranceCompany::all(),
            "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
