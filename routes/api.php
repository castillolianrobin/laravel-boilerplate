<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

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

Route::get('test-pusher', [\App\Http\Controllers\API\ChatRoomController::class, 'testEvent']);
Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    
    /** Broadcasting Authentication */
    Broadcast::routes();
    
    /** Authenticated API */
    
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    
    Route::get('inside-mware', function () {
        return response()->json('Success', 200);
    });

    Route::prefix('chat')->group(function () {
        Route::middleware('chatRoomMember:admin')->group(function () {
            Route::apiResource('rooms', \App\Http\Controllers\API\ChatRoomController::class);
            Route::resource('rooms.members', \App\Http\Controllers\API\ChatRoomMemberController::class)->shallow();
        });
        Route::resource('rooms.messages', \App\Http\Controllers\API\ChatRoomMessageController::class)->shallow()->middleware('chatRoomMember');
        
        // Leave specified room
        Route::post('rooms/{room}/members/leave',[ \App\Http\Controllers\API\ChatRoomMemberController::class, 'removeMembership' ]);
    });
});

// Lian's private API
Route::prefix('lian')->group(function () {
    Route::apiResource('snake-score', App\Http\Controllers\API\SnakeScoreController::class);
});