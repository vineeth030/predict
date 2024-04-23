<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\GameController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\VersionController;
use App\Http\Controllers\LabController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', function () {
    return view('home');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Matches page
Route::get('/games', [GameController::class, 'index'])->middleware('auth')->name('games');
Route::put('/games/{id}/update', [GameController::class, 'update'])->middleware('auth')->name('games.update');

// Standings Page
Route::get('/teams', [TeamController::class, 'index'])->middleware('auth')->name('teams.index');
Route::put('/teams/update', [TeamController::class, 'update'])->middleware('auth')->name('teams.update');


Route::get('/versions', [VersionController::class, 'index'])->middleware('auth')->name('versions');
Route::post('/updateversion', [VersionController::class, 'updateversion'])->middleware('auth')->name('updateversion');