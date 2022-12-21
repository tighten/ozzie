<?php

namespace App\Providers;

use App\Maintainer;
use App\Observers\MaintainerObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Maintainer::observe(MaintainerObserver::class);
    }
}
