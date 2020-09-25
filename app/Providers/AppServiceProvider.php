<?php

namespace App\Providers;

use App\GitHub\GitHub;
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
        // @todo: Bind to a non-internet-required version optionally based on flag in .env
        app()->bind('githubClient', function () {
            return new GitHub;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
