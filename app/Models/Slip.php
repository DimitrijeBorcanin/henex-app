<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function getFormattedSlipDateAttribute(){
        return Carbon::parse($this->attributes['check_date'])->format('d.m.Y.');
    }

    public function getFormattedStatusStartAttribute(){
        return number_format($this->attributes['status_start'], 2, ',', '.');
    }

    public function getFormattedReceivedAttribute(){
        return number_format($this->attributes['received'], 2, ',', '.');
    }

    public function getStatusEndAttribute(){
        return $this->attributes['status_start'] + $this->attributes['received'];
    }

    public function getFormattedStatusEndAttribute(){
        return number_format($this->getStatusEndAttribute(), 2, ',', '.');
    }

    public function updateState($column, $newAmount, $oldAmount = 0){
        $this->attributes[$column] = $this->attributes[$column] + $newAmount - $oldAmount;
        $this->save();
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
