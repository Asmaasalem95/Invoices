<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Modules\Invoice\Contracts\InvoiceRepositoryInterface;
use Modules\Invoice\Contracts\InvoiceServiceInterface;
use Modules\Invoice\Repositories\InvoiceRepository;
use Modules\Invoice\Services\InvoiceService;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InvoiceRepositoryInterface::class,InvoiceRepository::class);
        $this->app->bind(InvoiceServiceInterface::class,InvoiceService::class);
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
