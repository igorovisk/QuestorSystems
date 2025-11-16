<?php

namespace App\Providers;

use App\Repositories\BancoRepository;
use App\Repositories\BoletoRepository;
use App\Repositories\ClienteRepository;
use App\Repositories\Contracts\BancoRepositoryInterface;
use App\Repositories\Contracts\BoletoRepositoryInterface;
use App\Repositories\Contracts\ClienteRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Repository Bindings (Dependency Injection)
        $this->app->bind(ClienteRepositoryInterface::class, ClienteRepository::class);
        $this->app->bind(BancoRepositoryInterface::class, BancoRepository::class);
        $this->app->bind(BoletoRepositoryInterface::class, BoletoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
