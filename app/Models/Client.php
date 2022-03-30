<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];

    public function getFormattedFirstDateAttribute(){
        return Carbon::parse($this->attributes['first_date'])->format('d.m.Y.');
    }

    public function getFormattedLastDateAttribute(){
        if($this->attributes["last_date"]){
            return Carbon::parse($this->attributes['last_date'])->format('d.m.Y.');
        }
        return '-';
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}
