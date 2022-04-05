<?php

namespace App\Http\Livewire\Technicals;

use App\Models\Technical;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{

    public $technical;

    public function mount(Technical $technical){
        if(Auth::user()->role_id == 3 && $technical->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($technical->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }
        
        $this->technical = $technical;
    }

    public function render()
    {
        return view('livewire.technicals.show', ["technical" => $this->technical]);
    }
}
