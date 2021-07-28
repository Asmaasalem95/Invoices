<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\User\Contracts\UserServiceInterface;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserServiceInterface::class,\Modules\User\Services\UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
