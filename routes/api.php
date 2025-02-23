<?php

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

Route::middleware('auth:api')->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/states', \App\Http\Controllers\StateController::class)
        ->except(['create', 'edit', 'show']);
    Route::resource('/tasks', \App\Http\Controllers\TaskController::class)
        ->except(['index', 'create', 'edit']);
});

Route::middleware('guest:api')->group(function () {
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
});
