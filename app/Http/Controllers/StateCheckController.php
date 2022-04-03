<?php

namespace App\Http\Controllers;

use App\Models\DailyState;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StateCheckController extends Controller
{
    public function checkState(Request $request){
        $today = Carbon::now()->toDateString('YYYY-mm-dd');
        $location = $request->location;

        $stateToday = DailyState::where('state_date', $today)->where('location_id', $location)->exists();

        return response()->json(["isStateSet" => $stateToday]);
    }
}
