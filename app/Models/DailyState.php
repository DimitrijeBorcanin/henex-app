<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyState extends Model
{
    use HasFactory;

    protected $fillable = ["register_start", "location_id", "state_date"];

    public function getFormattedStateDateAttribute(){
        return Carbon::parse($this->attributes['state_date'])->format('d.m.Y.');
    }

    public function getRegisterEndAttribute(){
        return $this->attributes["register_start"]
            + $this->attributes["reg_cash"]
            + $this->attributes["tech_cash"]
            + $this->attributes["agency"]
            + $this->attributes["voucher"]
            + $this->attributes["adm"]
            + $this->attributes["incomes_cash"]
            - $this->attributes["expenses_cash"];
    }

    public function getRegistrationTotalAttribute(){
        return $this->attributes["reg_cash"]
            + $this->attributes["reg_check"]
            + $this->attributes["reg_card"]
            + $this->attributes["reg_firm"]
            + $this->attributes["tech_cash"]
            + $this->attributes["tech_check"]
            + $this->attributes["tech_card"]
            + $this->attributes["tech_invoice"]
            + $this->attributes["agency"]
            + $this->attributes["voucher"]
            + $this->attributes["adm"];
    }

    public function getFormattedRegistrationTotalAttribute(){
        return number_format($this->getRegistrationTotalAttribute(), 2, ',', '.');
    }

    public function getTechTotalAttribute(){
        return $this->attributes["tech_cash"]
            + $this->attributes["tech_check"]
            + $this->attributes["tech_card"]
            + $this->attributes["tech_invoice"]
            + $this->attributes["agency"]
            + $this->attributes["voucher"]
            + $this->attributes["adm"];
    }

    public function getFormattedTechTotalAttribute(){
        return number_format($this->getTechTotalAttribute(), 2, ',', '.');
    }

    public function getFormattedRegisterEndAttribute(){
        return number_format($this->getRegisterEndAttribute(), 2, ',', '.');
    }

    public function getFormattedAmount($att){
        if($att != null && $this->attributes[$att] != null){
            return number_format($this->attributes[$att], 2, ',', '.') . ' din.';
        }
        return '-';
    }

    public function getPolicyPercentAttribute(){
        $sum = 0;
        foreach($this->policies as $p){
            $sum += $p->policy;
        }
        return number_format($sum*0.05, 2, ',', '.') . ' din.';
    }

    public function updateState($column, $newAmount, $oldAmount = 0){
        $this->attributes[$column] = $this->attributes[$column] + $newAmount - $oldAmount;
        $this->save();
    }

    public function updatePolicy($id, $newAmount, $oldAmount = 0){
        $policy = $this->policies()->where('insurance_company_id', $id)->first();
        $policy->policy = $policy->policy + $newAmount - $oldAmount;
        $policy->save();
    }

    public function policies(){
        return $this->hasMany(DailyStatePolicy::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
