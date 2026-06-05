<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Redis;

return [

    'organization' => env('APP_ORG', 'tighten'),

    'twitter' => env('APP_TWITTER', 'tightenco'),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Redis::class,
    ])->toArray(),

];
