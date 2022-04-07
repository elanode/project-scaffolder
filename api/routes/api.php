<?php

use App\Domains\Authentication\Events\TestEvent;
use App\Domains\Authentication\Events\TestPrivateEvent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/user', App\Domains\Authentication\Http\Controllers\V1\MeController::class);
    Route::post('/logout',  App\Domains\Authentication\Http\Controllers\V1\LogoutController::class);
});

Route::get('test-broadcast', function () {
    event(new TestEvent(request('message', 'Hello World!')));
});

Route::get('test-private', function () {
    event(new TestPrivateEvent(1, request('message', 'testing')));
});
