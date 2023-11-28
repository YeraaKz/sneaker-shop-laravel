<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DemoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/demo', [DemoController::class, 'demo']);

Route::prefix('auth')->middleware('api')->controller(AuthController::class)->group(function (){
   Route::post('/register', 'register');
   Route::post('/login', 'login');
   Route::post('/logout', 'logout');
   Route::post('/refresh', 'refresh');
});


