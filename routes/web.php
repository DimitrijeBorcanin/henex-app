<?php

use App\Http\Livewire\Users;
use App\Http\Livewire\Technicals;
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
});
