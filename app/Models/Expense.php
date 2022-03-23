<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function getFormattedExpenseDateAttribute(){
        return Carbon::parse($this->attributes['expense_date'])->format('d.m.Y.');
    }

    public function getFormattedCashAttribute(){
        return number_format($this->attributes['cash'], 2, ',', '.');
    }

    public function getFormattedNonCashAttribute(){
        return number_format($this->attributes['non_cash'], 2, ',', '.');
    }

    public function expenseType(){
        return $this->belongsTo(ExpenseType::class);
    }
}
