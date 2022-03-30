<?php

namespace App\Http\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class Show extends Component
{
    public $client;

    public function mount(Client $client){
        $this->client = $client;
    }

    public function render()
    {
        return view('livewire.clients.show', ["client" => $this->client]);
    }
}
