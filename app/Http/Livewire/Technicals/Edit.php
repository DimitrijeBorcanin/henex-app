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
        "adm_non_cash" => "",
        "policy" => "",
        "policy_check" => "",
        "insurance_company_id" => "0",
        // "location_id" => "0",
        "returning" => "",
        "total" => ""
    ];

    public function mount(Technical $technical){
        $this->technical = $technical;

        if(Auth::user()->role_id == 3 && $technical->tech_date != Carbon::now()->toDateString('YYYY-mm-dd')){
            abort(403);
        }

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
            "adm_non_cash" => $this->technical->adm_non_cash ?? '',
            "policy" => $this->technical->policy,
            "policy_check" => $this->technical->policy_check,
            "insurance_company_id" => $this->technical->insurance_company_id ?? '0',
            // "location_id" => $this->technical->location_id,
            "returning" => $this->technical->returning != 0 ? true : false,
            "total" => $this->technical->total ?? ''
        ];
    }

    public function update(){

        if($this->technicalFields["insurance_company_id"] == "0"){
            $this->technicalFields["insurance_company_id"] == null;
        }

        Validator::make($this->technicalFields, [
            'reg_number' => ['string', 'max:255'],
            'tech_date' => ['required', 'date'],
            // 'reg_cash' => ['required_without_all:reg_check,reg_card,reg_firm', 'numeric'],
            // 'reg_check' => ['required_without_all:reg_cash,reg_card,reg_firm', 'numeric'],
            // 'reg_card' => ['required_without_all:reg_check,reg_cash,reg_firm', 'numeric'],
            // 'reg_firm' => ['required_without_all:reg_check,reg_card,reg_cash', 'numeric'],
            'reg_cash' => [''],
            'reg_check' => [''],
            'reg_card' => [''],
            'reg_firm' => [''],
            // 'tech_cash' => ['required_without_all:tech_check,tech_card,tech_invoice', 'numeric'],
            // 'tech_check' => ['required_without_all:tech_cash,tech_card,tech_invoice', 'numeric'],
            // 'tech_card' => ['required_without_all:tech_check,tech_cash,tech_invoice', 'numeric'],
            // 'tech_invoice' => ['required_without_all:tech_check,tech_cash,tech_card', 'numeric'],
            'tech_cash' => [''],
            'tech_check' => [''],
            'tech_card' => [''],
            'tech_invoice' => [''],
            'agency' => [''],
            'voucher' => [''],
            'adm' => [''],
            'adm_non_cash' => [''],
            'insurance_company_id' => ['exists:insurance_companies,id'],
            'policy' => [''],
            'policy_check' => [''],
            // 'location_id' => [Auth::user()->role_id != 3 ? 'required' : '',
            //                 Auth::user()->role_id != 3 ? 'not_in:0' : '',
            //                 Auth::user()->role_id != 3 ? 'exists:locations,id' : '',
            //                 function($att, $val, $fail){
            //                     if(Auth::user()->role_id == 2 && in_array($val, Auth::user()->locations()->pluck('location_id')->toArray())){
            //                         $fail('Odabrana je nedozvoljena lokacija.');
            //                     }
            //                 }],
            'returning' => [],
            'total' => ['numeric']
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
            // 'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'required_without_all' => 'Mora biti upisan bar jedan način plaćanja.',
            'numeric' => 'Mora biti broj.'
        ])->validate();

        foreach($this->technicalFields as $field => $value){
            if(empty($value) && $field != "returning"){
                $this->technicalFields[$field] = null;
            }
        }

        // if(Auth::user()->role_id == 3){
        //     $this->technical['location_id'] = Auth::user()->location_id;
        // }

        $state = DailyState::where('state_date', $this->technical["tech_date"])->where('location_id', $this->technical["location_id"])->first();
        if(!$state){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Nije postavljena dnevna tabela za danas za ovu lokaciju!']);
            return;
        }

        try {
            DB::beginTransaction();

            $oldState = DailyState::where('state_date', $this->technical->tech_date)->where('location_id', $this->technical->location_id)->first();
            $oldState->updateState('reg_cash', 0, $this->technical["reg_cash"]);
            $oldState->updateState('reg_check', 0, $this->technical["reg_check"]);
            $oldState->updateState('reg_card', 0, $this->technical["reg_card"]);
            $oldState->updateState('reg_firm', 0, $this->technical["reg_firm"]);
            $oldState->updateState('tech_cash', 0, $this->technical["tech_cash"]);
            $oldState->updateState('tech_check', 0, $this->technical["tech_check"]);
            $oldState->updateState('tech_card', 0, $this->technical["tech_card"]);
            $oldState->updateState('tech_invoice', 0, $this->technical["tech_invoice"]);
            $oldState->updateState('agency', 0, $this->technical["agency"]);
            $oldState->updateState('voucher', 0, $this->technical["voucher"]);
            $oldState->updateState('adm', 0, $this->technical["adm"]);
            $oldState->updateState('adm_non_cash', 0, $this->technical["adm_non_cash"]);

            if($this->technical["voucher"] && $this->technical["voucher"] > 0){
                $oldState->voucher_no = $oldState->voucher_no - 1;
                $oldState->save();
            }

            if(!$this->technical["returning"]){
                $state->technical_no = $oldState->technical_no - 1;
                $state->save();
            }

            $oldCheck = Check::where('check_date', $this->technical->tech_date)->where('location_id', $this->technical->location_id)->first();
            if($this->technical["tech_check"] && $this->technical["tech_check"] > 0){
                $oldCheck->updateState('received', 0, $this->technical["tech_check"]);
            }
            if($this->technical["reg_check"] && $this->technical["reg_check"] > 0){
                $oldCheck->updateState('received', 0, $this->technical["reg_check"]);
            }
            if($this->technical["policy_check"] && $this->technical["policy_check"] > 0){
                $oldCheck->updateState('debited', 0, $this->technical["policy_check"]);
            }

            $this->technical->update($this->technicalFields);
            
            $state = DailyState::where('state_date', $this->technical->tech_date)->where('location_id', $this->technical->location_id)->first();
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
            return redirect()->route('technicals.show', ["technical" => $this->technical->id]);
        } catch (Throwable $e){
            DB::rollBack();
        } 
  
    }

    public function render()
    {
        return view('livewire.technicals.edit', [
            'companies' => InsuranceCompany::all(),
            // "locations" => Auth::user()->role_id == 2 ? Auth::user()->locations : Location::all()
        ]);
    }
}
