<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LabController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\PointController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\PredictionController;
use App\Http\Controllers\Api\ProfileController;

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
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user/profile', [ProfileController::class, 'profile']);

Route::post('/auth-lab', [LabController::class, 'sendRequest'])->name('auth-lab.sendRequest');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/games', [GameController::class, 'index']);

    Route::get('/points', [PointController::class, 'index']);
    Route::get('/points/user/show', [PointController::class, 'show']);

    Route::get('/predictions', [PredictionController::class, 'index']);
    Route::get('/predictions/user/show', [PredictionController::class, 'show']);
    Route::post('/predictions/update', [PredictionController::class, 'update']);

    Route::get('/versions', [VersionController::class, 'index']);

    Route::get('/teams', [TeamController::class, 'index']);

    Route::get('/user-points/{userId}/total', [PointController::class, 'getTotalPointsForUser']);
    Route::get('/head-to-head/', [PointController::class, 'headtoHead']);
    Route::get('/matches/{matchId}/top-predictions', [PredictionController::class, 'getTop3PredictionsForMatch']);
    Route::get('/users/allUserPoints', [PointController::class, 'allUserPoints']);
   Route::post('/profile', [ProfileController::class, 'update']);
  //  Route::put('profile', 'ProfileController@update');


});
