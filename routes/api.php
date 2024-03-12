<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\VersionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function(){

    Route::get('/games', [GameController::class, 'index']);

    Route::get('/points', [PointController::class, 'index']);
    Route::get('/points/user/show', [PointController::class, 'show']);
    
    Route::get('/predictions', [PredictionController::class, 'index']);
    Route::get('/predictions/user/show', [PredictionController::class, 'show']);
    Route::post('/predictions/update', [PredictionController::class, 'update']);

    Route::get('/versions', [VersionController::class, 'index']);

    Route::get('/teams', [TeamController::class, 'index']);
});