<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['csp_header', 'access_control_headers']], function () {
    Route::get('/auth', [AuthController::class, 'auth'])->name('auth');
    Route::get('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');

    Route::get('/{path?}', [HomeController::class, 'index'])
        ->where('path', '^(?!admin|filament|livewire).*$')
        ->middleware(['verify.hmac', 'shopify.install', 'verify.token']);
});
