<?php

namespace App\Providers;

use App\Models\Maintainer;
use App\Observers\MaintainerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Maintainer::observe(MaintainerObserver::class);
    }
}
