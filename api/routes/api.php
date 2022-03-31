<?php

use App\Domains\Authentication\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', App\Http\Controllers\V1\Authentication\MeController::class);
    Route::post('/logout',  App\Http\Controllers\V1\Authentication\LogoutController::class);
});
