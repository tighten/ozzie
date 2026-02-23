<?php

use Illuminate\Support\Facades\Facade;

return [

    'organization' => env('APP_ORG', 'tighten'),

    'twitter' => env('APP_TWITTER', 'tightenco'),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
