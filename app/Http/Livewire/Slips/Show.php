<?php

namespace App\Http\Livewire\Slips;

use App\Models\Slip;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $slip;

    public function mount(Slip $slip){
        if(Auth::user()->role_id == 3 && $slip->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($slip->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }
        
        $this->slip = $slip;
    }

    public function render()
    {
        return view('livewire.slips.show', ["slip" => $this->slip]);
    }
}
