<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function getFormattedIncomeDateAttribute(){
        return Carbon::parse($this->attributes['income_date'])->format('d.m.Y.');
    }

    public function getFormattedExcerptDateAttribute(){
        if($this->attributes['excerpt_date']){
            return Carbon::parse($this->attributes['excerpt_date'])->format('d.m.Y.');
        } else {
            return '-';
        }
    }

    public function getFormattedCashAttribute(){
        return number_format($this->attributes['cash'], 2, ',', '.');
    }

    public function getFormattedNonCashAttribute(){
        return number_format($this->attributes['non_cash'], 2, ',', '.');
    }

    public function getFormattedExcerptStatusAttribute(){
        return number_format($this->attributes['excerpt_status'], 2, ',', '.');
    }

    public function incomeType(){
        return $this->belongsTo(IncomeType::class);
    }
}
