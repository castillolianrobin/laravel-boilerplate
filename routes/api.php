<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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
    
    
    // Chat room
    Route::prefix('chat')->group(function () {
        Route::middleware('chatRoomMember:admin')->group(function () {
            Route::apiResource('rooms', \App\Http\Controllers\API\ChatRoomController::class);
            Route::resource('rooms.members', \App\Http\Controllers\API\ChatRoomMemberController::class)->shallow();
        });
        Route::resource('rooms.messages', \App\Http\Controllers\API\ChatRoomMessageController::class)
            ->shallow()
            ->middleware('chatRoomMember');
        
        // Leave specified room
        Route::post('rooms/{room}/members/leave',[ \App\Http\Controllers\API\ChatRoomMemberController::class, 'removeMembership' ]);
    });
    // User
    Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);
    Route::apiResource('users', \App\Http\Controllers\API\UserController::class);
    Route::resource('users.details', \App\Http\Controllers\API\UserDetailController::class);
    // Settings
    Route::prefix('settings')->group(function () {
        Route::put('profile', [\App\Http\Controllers\API\SettingsController::class, 'updateProfile']);
    });
});

Route::get('env', function () {
    Storage::put('test/test/example.txt', 'TEST');
    $test = Storage::get('test/test/example.txt');
    echo $test;
    echo '<br/>';
    echo Storage::url('test/test/example.txt');
    // return response()->json($test);
});

// Lian's private API
Route::prefix('lian')->group(function () {
    Route::apiResource('snake-score', App\Http\Controllers\API\SnakeScoreController::class);
});