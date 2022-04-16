<?php

namespace App\Http\Livewire\Slips;

use App\Models\Slip;
use Livewire\Component;

class Show extends Component
{
    public $slip;

    public function mount(Slip $slip){
        $this->slip = $slip;
    }

    public function render()
    {
        return view('livewire.slips.show', ["slip" => $this->slip]);
    }
}
