<?php

use App\Http\Controllers\v1\Docs\AuthenticateDocsController;
use App\Http\Controllers\v1\Docs\DocsViewController;
use App\Http\Controllers\v1\Docs\LoginDocsViewController;
use App\Http\Controllers\v1\Docs\LogoutDocsController;
use Illuminate\Support\Facades\Route;

Route::prefix('docs')->group(function () {
    Route::get('/', LoginDocsViewController::class)->name('docs.login');
    Route::post('/', AuthenticateDocsController::class)->name('docs.authenticate');
    Route::get('/api', DocsViewController::class)
        ->middleware(['docs.auth'])
        ->name('docs.api');
    Route::post('/logout', LogoutDocsController::class)->name('docs.logout');
});
