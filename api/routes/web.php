<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('login', 'login');
Route::post('login', App\Domains\Authentication\Http\Controllers\V1\LoginController::class)->name('login');
