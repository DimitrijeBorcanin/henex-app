<?php

namespace App\Http\Livewire\Incomes;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $income;

    public function mount(Income $income){
        if(Auth::user()->role_id == 3 && $income->income_date != Carbon::now()->toDateString('YYYY-mm-dd')){
            abort(403);
        }

        if(Auth::user()->role_id == 3 && $income->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($income->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }

        $this->income = $income;
    }

    public function render()
    {
        return view('livewire.incomes.show', ["income" => $this->income]);
    }
}
