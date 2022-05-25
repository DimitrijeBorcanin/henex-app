<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $check;

    public function mount(Check $check){
        if(Auth::user()->role_id == 3 && $check->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($check->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }
        $this->check = $check;
    }

    public function render()
    {
        return view('livewire.checks.show', ["check" => $this->check]);
    }
}
