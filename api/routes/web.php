<?php

use App\Domains\Authentication\Http\Controllers\V1\ResetPasswordController;
use App\Domains\Authentication\Http\Controllers\V1\ResetPasswordViewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('login', 'login');
Route::post('login', App\Domains\Authentication\Http\Controllers\V1\LoginController::class)->name('login');
Route::get('reset-password/{token}', ResetPasswordViewController::class)->middleware('guest')->name('password.reset');
Route::post('reset-password', ResetPasswordController::class)->name('password.update');
