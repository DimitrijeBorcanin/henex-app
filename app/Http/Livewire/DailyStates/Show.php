<?php

namespace App\Http\Livewire\DailyStates;

use App\Models\DailyState;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $state;

    public function mount(DailyState $state){
        if(Auth::user()->role_id == 3 && $state->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($state->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }

        $this->state = $state;
    }

    public function render()
    {
        return view('livewire.daily-states.show', [
            "state" => $this->state
        ]);
    }
}
