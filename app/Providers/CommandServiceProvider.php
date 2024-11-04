<?php

namespace App\Providers;

use App\Storage\Commands\User as UserCommand;
use App\Contracts\Commands\User as IUserCommand;
use Illuminate\Support\ServiceProvider;

class CommandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            IUserCommand::class,
            UserCommand::class
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
