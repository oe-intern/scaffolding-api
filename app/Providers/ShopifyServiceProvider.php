<?php

namespace App\Providers;

use App\Contracts\Shopify\Graphql\ShopLocale;
use App\Services\Shopify\Graphql\ShopLocaleService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Shopify\Graphql\Shop as IShop;
use App\Services\Shopify\Graphql\ShopService;

class ShopifyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            IShop::class,
            ShopService::class
        );

        $this->app->bind(
            ShopLocale::class,
            ShopLocaleService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
