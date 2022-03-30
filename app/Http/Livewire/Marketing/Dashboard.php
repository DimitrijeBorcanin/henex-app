<?php

namespace App\Http\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    
    public function render()
    {
        return view('livewire.marketing.dashboard');
    }
}
