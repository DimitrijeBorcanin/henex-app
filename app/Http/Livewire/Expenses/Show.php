<?php

namespace App\Http\Livewire\Expenses;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $expense;

    public function mount(Expense $expense){

        if(Auth::user()->role_id == 3 && $expense->expense_date != Carbon::now()->toDateString('YYYY-mm-dd')){
            abort(403);
        }

        if(Auth::user()->role_id == 3 && $expense->location_id != Auth::user()->location_id){
            abort(403);
        }

        if(Auth::user()->role_id == 2 && !in_array($expense->location_id, Auth::user()->locations()->pluck('location_id')->toArray())){
            abort(403);
        }

        $this->expense = $expense;
    }

    public function render()
    {
        return view('livewire.expenses.show', ["expense" => $this->expense]);
    }
}
