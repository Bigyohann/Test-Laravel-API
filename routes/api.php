<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Authentification\AuthController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
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
    Route::post('/login', [AuthController::class, 'login'] )->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});


Route::apiResource('users', UserController::class)->middleware(['auth:api', 'roles:ADMIN']);

Route::apiResource('topics', TopicController::class)->middleware(['auth:api', 'roles:ADMIN']);

Route::get('/', [ApiController::class, 'getApiInformation'])->name('apiinformations');

Route::fallback([ApiController::class, 'fallbackResponseFor404']);
