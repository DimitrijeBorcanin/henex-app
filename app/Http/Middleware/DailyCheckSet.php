<?php

namespace App\Http\Middleware;

use App\Models\Check;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyCheckSet
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
        if(Auth::user()->role_id != 3){
            return $next($request);
        }
        $checkToday = Check::where('check_date', Carbon::now()->toDateString('YYYY-mm-dd'))->where('location_id', Auth::user()->location_id)->first();
        if($checkToday){
            return $next($request);
        }
        return redirect()->route('checks.create');
    }
}
