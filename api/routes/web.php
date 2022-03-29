<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('login', 'login');
Route::post('login', App\Http\Controllers\V1\Authentication\LoginController::class)->name('login');
