<?php

use Illuminate\Support\Facades\Route;
use Osiset\ShopifyApp\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| Here is where you can register webhook routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "webhook" middleware group. Make something great!
|
*/

Route::post('{type?}', [WebhookController::class, 'handle']);
