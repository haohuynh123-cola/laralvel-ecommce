<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register your model observers here, e.g.:
        // \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        // Keep empty by default to avoid binding missing classes on fresh apps.
    }
}
