<?php

namespace App\Http\Middleware;

use App\Models\DailyState;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyStateSet
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $stateToday = DailyState::where('state_date', Carbon::now()->toDateString('YYYY-mm-dd'))->where('location_id', Auth::user()->location_id)->first();
        if($stateToday){
            return $next($request);
        }
        return redirect()->route('daily-states.create');
    }
}
