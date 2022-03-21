<?php

namespace App\Http\Livewire\Technicals;

use App\Models\Technical;
use Livewire\Component;

class Show extends Component
{

    public $technical;

    public function mount(Technical $technical){
        $this->technical = $technical;
    }

    public function render()
    {
        return view('livewire.technicals.show', ["technical" => $this->technical]);
    }
}
