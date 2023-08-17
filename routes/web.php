<?php

use App\Http\Controllers\UserReplicationController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/replicate-users', [UserReplicationController::class, 'replicate']);


// Route::get('/.well-known/pki-validation/42746A0092156F7EB651B617383BC8AB.txt', [\App\Http\Controllers\SSLController::class, 'getDownload']);