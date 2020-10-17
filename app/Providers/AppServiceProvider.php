<?php

namespace App\Providers;

use App\GitHub\GitHub;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        app()->bind('mygithub', function () {
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
        Inertia::version(function () {
            return md5_file(public_path('mix-manifest.json'));
        });
    }
}
