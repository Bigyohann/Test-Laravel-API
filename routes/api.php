<?php

use App\Http\Controllers\ApiBaseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware([])->name('auth')->group(function (){
    Route::post('/login', [\App\Http\Controllers\Authentification\AuthController::class, 'login'] )->name('login');
    Route::post('/register', [\App\Http\Controllers\Authentification\AuthController::class, 'register'])->name('register');
});


Route::apiResource('users', UserController::class)->middleware(['auth:api', 'roles:ADMIN']);

Route::get('/', [ApiBaseController::class, 'getApiInformation'])->name('apiinformations');

Route::fallback(function(){
    return response()->json([
        'message' => 'No url are matching'], 404);
});
