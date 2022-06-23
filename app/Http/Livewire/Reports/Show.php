<?php

namespace App\Http\Livewire\Reports;

use App\Models\DailyState;
use App\Models\InsuranceCompany;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $months = [
        "1" => "Januar",
        "2" => "Februar",
        "3" => "Mart",
        "4" => "April",
        "5" => "Maj",
        "6" => "Jun",
        "7" => "Jul",
        "8" => "Avgust",
        "9" => "Septembar",
        "10" => "Oktobar",
        "11" => "Novembar",
        "12" => "Decembar"
    ];

    public $filter = [
        "month" => "",
        "year" => ""
    ];

    public $reports = [
        "technical_no" => 0,
        "profit" => 0,
        "policies" => [],
        "totalPolicy" => 0
    ];

    public function mount(){
        $this->filter["month"] = Carbon::now()->month;
        $this->filter["year"] = Carbon::now()->year;
        $this->getReportData();
    }

    public function getReportData(){
        $this->reports["technical_no"] = DailyState::whereMonth('state_date', $this->filter["month"])->whereYear('state_date', $this->filter["year"])->sum('technical_no');

        $insuranceCompanies = InsuranceCompany::all();
        foreach($insuranceCompanies as $insurance){
            $this->reports["policies"][$insurance->id] = [
                "name" => $insurance->name,
                "amount" => 0
            ];
        }
        $this->reports["profit"] = 0;
        $dailyStates = DailyState::with('policies')->whereMonth('state_date', $this->filter["month"])->whereYear('state_date', $this->filter["year"])->get();
        foreach($dailyStates as $state){
            $this->reports["profit"] += $state->tech_total;

            foreach($state->policies as $policy){
                $this->reports["policies"][$policy->insurance_company_id]["amount"] += $policy->policy;
            }
        }

        $this->reports["totalPolicy"] = $this->getTotalPolicies();
    }

    private function getTotalPolicies(){
        $sum = 0;
        foreach($this->reports["policies"] as $policy){
            $sum += $policy["amount"];
        }
        return $sum;
    }

    public function updatedFilter(){
        $this->getReportData();
    }

    public function render()
    {
        return view('livewire.reports.show');
    }
}
