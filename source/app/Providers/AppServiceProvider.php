<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Service\UserServiceInterface;
use App\Services\UserService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind user service interface to implementation
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->register(ObserverServiceProvider::class);
    }
}
