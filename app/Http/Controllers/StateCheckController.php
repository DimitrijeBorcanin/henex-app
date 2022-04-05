<?php

namespace App\Http\Controllers;

use App\Models\DailyState;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StateCheckController extends Controller
{
    public function checkState(Request $request){

        if(Auth::user()->role_id != 3){
            return response()->json(["isStateSet" => true]);
        }

        $today = Carbon::now()->toDateString('YYYY-mm-dd');
        $location = $request->location;

        $stateToday = DailyState::where('state_date', $today)->where('location_id', Auth::user()->location_id)->exists();

        return response()->json(["isStateSet" => $stateToday]);
    }
}
