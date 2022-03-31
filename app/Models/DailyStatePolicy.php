<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyStatePolicy extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function getFormattedPolicyAttribute(){
        return number_format($this->attributes["policy"], 2, ',', '.');
    }

    public function dailyState(){
        return $this->belongsTo(DailyState::class);
    }

    public function insuranceCompany(){
        return $this->belongsTo(InsuranceCompany::class);
    }
}
