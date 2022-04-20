<?php

use App\Domains\Authentication\Events\TestEvent;
use App\Domains\Authentication\Events\TestPrivateEvent;
use Illuminate\Support\Facades\Route;

Route::get('test-broadcast', function () {
    event(new TestEvent(request('message', 'Hello World!')));
});

Route::get('test-private', function () {
    event(new TestPrivateEvent(1, request('message', 'testing')));
});
