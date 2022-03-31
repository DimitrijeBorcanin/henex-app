<?php

namespace App\Http\Livewire\DailyStates;

use App\Models\DailyState;
use Livewire\Component;

class Show extends Component
{
    public $state;

    public function mount(DailyState $state){
        $this->state = $state;
    }

    public function render()
    {
        return view('livewire.daily-states.show', [
            "state" => $this->state
        ]);
    }
}
