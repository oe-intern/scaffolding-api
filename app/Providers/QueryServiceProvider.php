<?php

namespace App\Providers;

use App\Storage\Queries\User as UserQuery;
use App\Contracts\Queries\User as IUserQuery;
use Illuminate\Support\ServiceProvider;

class QueryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            IUserQuery::class,
            UserQuery::class
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
