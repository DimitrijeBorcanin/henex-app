<?php

use App\Http\Livewire\Users;
use App\Http\Livewire\Technicals;
use App\Http\Livewire\Expenses;
use App\Http\Livewire\Incomes;
use App\Http\Livewire\Clients;
use App\Http\Livewire\Marketing;
use App\Http\Livewire\Checks;
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
    Route::get('/technicals/create', Technicals\Create::class)->name('technicals.create');
    Route::get('/technicals/{technical}', Technicals\Show::class)->name('technicals.show');
    Route::get('/technicals/{technical}/edit', Technicals\Edit::class)->name('technicals.edit');

    Route::middleware(['admin'])->group(function(){
        Route::get('/expenses', Expenses\ShowAll::class)->name('expenses');
        Route::get('/expenses/create', Expenses\Create::class)->name('expenses.create');
        Route::get('/expenses/{expense}', Expenses\Show::class)->name('expenses.show');
        Route::get('/expenses/{expense}/edit', Expenses\Edit::class)->name('expenses.edit');

        Route::get('/incomes', Incomes\ShowAll::class)->name('incomes');
        Route::get('/incomes/create', Incomes\Create::class)->name('incomes.create');
        Route::get('/incomes/{income}', Incomes\Show::class)->name('incomes.show');
        Route::get('/incomes/{income}/edit', Incomes\Edit::class)->name('incomes.edit');

        Route::get('/checks', Checks\ShowAll::class)->name('checks');
        Route::get('/checks/create', Checks\Create::class)->name('checks.create');
        Route::get('/checks/{check}', Checks\Show::class)->name('checks.show');
        Route::get('/checks/{check}/edit', Checks\Edit::class)->name('checks.edit');

        Route::get('/marketing', function(){
            return view('livewire.marketing.dashboard');
        })->name('marketing');
        // Route::get('/marketing', Marketing\Dashboard::class)->name('marketing');
        Route::get('/clients/create', Clients\Create::class)->name('clients.create');
        Route::get('/clients/{client}', Clients\Show::class)->name('clients.show');
        Route::get('/clients/{client}/edit', Clients\Edit::class)->name('clients.edit');
    });
});
