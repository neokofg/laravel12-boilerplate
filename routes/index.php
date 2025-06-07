<?php

use App\Http\Controllers\v1\Auth\LoginUserController;
use App\Http\Controllers\v1\Auth\LogoutUserController;
use App\Http\Controllers\v1\Auth\RegisterUserController;
use App\Http\Controllers\v1\User\GetAuthenticatedUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:api')->group(function () {
    Route::prefix('api')->group(function () {
        Route::prefix('v1')->group(function () {
            Route::prefix('auth')->middleware('throttle:auth')->group(function () {
                Route::post('register', RegisterUserController::class)
                    ->middleware(['throttle:auth:register']);
                Route::post('login', LoginUserController::class);
                Route::post('logout', LogoutUserController::class)
                    ->middleware(['auth:sanctum']);
            });
            Route::prefix('user')->middleware('auth:sanctum')->group(function () {
                Route::get('', GetAuthenticatedUserController::class);
            });
        });
    });

    if (!app()->isProduction()) {
        Route::get('', function () {
            return fast_response('status', [
                'all systems operational'
            ]);
        });

        Route::get('test', function () {
            return fast_response('test', [
                'pong'
            ]);
        });
    }
});
