<?php

use App\Http\Controllers\API\Shopify\ProductController as ShopifyProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::namespace('API')->name('api.')->group(function () {
    Route::middleware(['verify.shopify'])->group(function () {
        // Shopify resource
        Route::prefix('shopify')->name('shopify.')->group(function () {
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('/', [ShopifyProductController::class, 'index'])->name('index');
                Route::get('{shopifyId}', [ShopifyProductController::class, 'show'])->name('show');
            });
        });
    });
});
