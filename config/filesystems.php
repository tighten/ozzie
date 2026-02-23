<?php

return [

    'disks' => [
        'root' => [
            'driver' => 'local',
            'root' => base_path(''),
        ],

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],
    ],

];
