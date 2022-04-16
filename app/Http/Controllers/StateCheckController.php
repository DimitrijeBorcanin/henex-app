<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\DailyState;
use App\Models\Slip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StateCheckController extends Controller
{
    public function checkState(){

        if(Auth::user()->role_id != 3){
            return response()->json(["isStateSet" => true]);
        }

        $today = Carbon::now()->toDateString('YYYY-mm-dd');

        $stateToday = DailyState::where('state_date', $today)->where('location_id', Auth::user()->location_id)->exists();

        return response()->json(["isStateSet" => $stateToday]);
    }

    public function checkCheck(){

        if(Auth::user()->role_id != 3){
            return response()->json(["isCheckSet" => true]);
        }

        $today = Carbon::now()->toDateString('YYYY-mm-dd');

        $checkToday = Check::where('check_date', $today)->where('location_id', Auth::user()->location_id)->exists();

        return response()->json(["isCheckSet" => $checkToday]);
    }

    public function slipCheck(){

        if(Auth::user()->role_id != 3){
            return response()->json(["isSlipSet" => true]);
        }

        $today = Carbon::now()->toDateString('YYYY-mm-dd');

        $slipToday = Slip::where('slip_date', $today)->where('location_id', Auth::user()->location_id)->exists();

        return response()->json(["isCheckSet" => $slipToday]);
    }
}
