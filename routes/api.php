<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ChatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| 
*/


Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    
    Route::get('inside-mware', function () {
        return response()->json('Success', 200);
    });

    Route::group(['prefix' => 'chat'], function () {
        Route::get('rooms', [ChatController::class, 'rooms']);
        Route::get('room/{roomId}/messages', [ChatController::class, 'messages']);
        Route::post('room/{roomId}/message', [ChatController::class, 'newMessage']);
    });
});


// Lian's private API
Route::prefix('lian')->group(function () {
    Route::apiResource('snake-score', App\Http\Controllers\API\SnakeScoreController::class);
    Route::get('reduce-score', [App\Http\Controllers\API\SnakeScoreController::class, 'reduceScore']);
});