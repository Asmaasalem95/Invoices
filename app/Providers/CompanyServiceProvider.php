<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Company\Contracts\CompanyServiceInterface;
use Modules\Company\Services\CompanyService;
class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompanyServiceInterface::class,CompanyService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
