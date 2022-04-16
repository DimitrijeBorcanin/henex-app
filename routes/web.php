<?php

use App\Http\Controllers\StateCheckController;
use App\Http\Livewire\Users;
use App\Http\Livewire\Technicals;
use App\Http\Livewire\Expenses;
use App\Http\Livewire\Incomes;
use App\Http\Livewire\Clients;
use App\Http\Livewire\Marketing;
use App\Http\Livewire\Checks;
use App\Http\Livewire\DailyStates;
use App\Http\Livewire\Slips;
use App\Models\DailyState;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/', function(){
        return view('dashboard');
    })->name('dashboard');
    Route::get('/users', Users\ShowAll::class)->name('users')->middleware('admin');

    Route::get('/technicals', Technicals\ShowAll::class)->name('technicals');
    Route::get('/technicals/create', Technicals\Create::class)->name('technicals.create')->middleware(['daily-state', 'daily-check']);
    Route::get('/technicals/{technical}', Technicals\Show::class)->name('technicals.show');
    Route::get('/technicals/{technical}/edit', Technicals\Edit::class)->name('technicals.edit');

    Route::get('/check-daily-state', [StateCheckController::class, 'checkState']);
    Route::get('/check-daily-check', [StateCheckController::class, 'checkCheck']);

    Route::get('/daily-states/create', DailyStates\Create::class)->name('daily-states.create');
    Route::get('/daily-states/{state}', DailyStates\Show::class)->name('daily-states.show');

    Route::get('/slips/create', Slips\Create::class)->name('slips.create');
    Route::get('/slips/{state}', Slips\Show::class)->name('slips.show');

    Route::get('/expenses', Expenses\ShowAll::class)->name('expenses');
    Route::get('/expenses/create', Expenses\Create::class)->name('expenses.create')->middleware(['daily-state', 'daily-check']);
    Route::get('/expenses/{expense}', Expenses\Show::class)->name('expenses.show');

    Route::get('/incomes', Incomes\ShowAll::class)->name('incomes');
    Route::get('/incomes/create', Incomes\Create::class)->name('incomes.create')->middleware(['daily-state', 'daily-check']);
    Route::get('/incomes/{income}', Incomes\Show::class)->name('incomes.show');

    Route::get('/checks', Checks\ShowAll::class)->name('checks');
    Route::get('/checks/create', Checks\Create::class)->name('checks.create');
    Route::get('/checks/{check}', Checks\Show::class)->name('checks.show');

    Route::get('/marketing', function(){
        return view('livewire.marketing.dashboard');
    })->name('marketing');
    // Route::get('/marketing', Marketing\Dashboard::class)->name('marketing');
    Route::get('/clients/create', Clients\Create::class)->name('clients.create');
    Route::get('/clients/{client}', Clients\Show::class)->name('clients.show');

    Route::middleware(['admin'])->group(function(){
        Route::get('/daily-states', DailyStates\ShowAll::class)->name('daily-states');
        // Route::get('/daily-states/{state}/edit', DailyStates\Edit::class)->name('daily-states.edit');
        Route::get('/slips', Slips\ShowAll::class)->name('slips');

        Route::get('/expenses/{expense}/edit', Expenses\Edit::class)->name('expenses.edit');
 
        Route::get('/incomes/{income}/edit', Incomes\Edit::class)->name('incomes.edit');
    
        Route::get('/checks/{check}/edit', Checks\Edit::class)->name('checks.edit');

        Route::get('/clients/{client}/edit', Clients\Edit::class)->name('clients.edit');
    });
});
