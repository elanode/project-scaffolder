<?php

/** 
 * URL : /authentication/ ..
 */

use App\Domains\Authentication\Actions\SendResetPasswordEmailAction;
use App\Domains\Authentication\Http\Controllers\V1\ForgotPasswordController;
use App\Domains\Authentication\Http\Controllers\V1\ResetPasswordController;
use App\Domains\Authentication\Http\Controllers\V1\ResetPasswordViewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('/forgot-password', ForgotPasswordController::class)->name('password.request');
});

Route::prefix('authentication')
    ->name('authentication.')
    ->group(function () {

        // PUBLIC

        // GUEST

        // AUTHENTICATED 
        Route::middleware('auth:api')->group(function () {

            // /authentication/..
            Route::get('user', App\Domains\Authentication\Http\Controllers\V1\MeController::class);
            Route::post('logout',  App\Domains\Authentication\Http\Controllers\V1\LogoutController::class);

            // /authentication/users/ .. 
            Route::prefix('users')
                ->name('users.')
                ->group(function () {
                    Route::get('', App\Domains\Authentication\Http\Controllers\V1\GetAllUserController::class)->name('index');
                    Route::post('', App\Domains\Authentication\Http\Controllers\V1\CreateNewUserController::class)->name('create');
                    Route::put('/{id}', App\Domains\Authentication\Http\Controllers\V1\UpdateUserAccountController::class)->name('update');
                    Route::post('/terminate', App\Domains\Authentication\Http\Controllers\V1\TerminateUserController::class)->name('terminate');

                    Route::post('/attach-roles', App\Domains\Authentication\Http\Controllers\V1\AttachUserToRoleController::class)->name('attach-roles');

                    // /authentication/users/my-account/ ..  
                    Route::prefix('my-account')
                        ->name('my-account.')
                        ->group(function () {
                            Route::put('update', App\Domains\Authentication\Http\Controllers\V1\UpdateMyUserAccountController::class)->name('update');
                        });
                });
        });
    });
