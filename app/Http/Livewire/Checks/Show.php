<?php

namespace App\Http\Livewire\Checks;

use App\Models\Check;
use Livewire\Component;

class Show extends Component
{
    public $check;

    public function mount(Check $check){
        $this->check = $check;
    }

    public function render()
    {
        return view('livewire.checks.show', ["check" => $this->check]);
    }
}
