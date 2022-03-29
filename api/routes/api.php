<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', App\Http\Controllers\V1\Authentication\MeController::class);
    Route::post('/logout',  App\Http\Controllers\V1\Authentication\LogoutController::class);
});
