<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getTechSumAttribute(){
        return $this->attributes['tech_cash'] 
                + $this->attributes['tech_check'] 
                + $this->attributes['tech_card'] 
                + $this->attributes['tech_invoice'] 
                + $this->attributes['agency']
                + $this->attributes['voucher']
                + $this->attributes['adm'];
    }

    public function getFormattedTechSumAttribute(){
        return number_format($this->getTechSumAttribute(), 2, ',', '.');
    }

    public function getRegSumAttribute(){
        return $this->attributes['reg_cash'] 
                + $this->attributes['reg_check'] 
                + $this->attributes['reg_card'] 
                + $this->attributes['reg_firm'];
    }

    public function getAmountAttribute(){
        return $this->getTechSumAttribute() + $this->getRegSumAttribute();
        
    }

    public function getFormattedAmountAttribute(){
        return number_format($this->getAmountAttribute(), 2, ',', '.');
    }

    public function getFormattedTechDateAttribute(){
        return Carbon::parse($this->attributes['tech_date'])->format('d.m.Y.');
    }

    public function getFormattedAmount($att){
        if($att != null && $this->attributes[$att] != null){
            return number_format($this->attributes[$att], 2, ',', '.') . ' din.';
        }
        return '-';
    }

    public function insuranceCompany(){
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
