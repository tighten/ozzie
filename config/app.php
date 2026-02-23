<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'organization' => env('APP_ORG', 'tighten'),

    'twitter' => env('APP_TWITTER', 'tightenco'),

    'providers' => ServiceProvider::defaultProviders()->merge(array_filter([
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        (env('APP_ENV', 'production') != 'testing' ? App\Providers\NovaServiceProvider::class : null),
        App\Providers\RouteServiceProvider::class,
    ]))->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
