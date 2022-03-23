<?php

namespace App\Http\Livewire\Incomes;

use App\Models\Income;
use Livewire\Component;

class Show extends Component
{
    public $income;

    public function mount(Income $income){
        $this->income = $income;
    }

    public function render()
    {
        return view('livewire.incomes.show', ["income" => $this->income]);
    }
}
