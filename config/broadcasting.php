<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    */
    'default' => env('BROADCAST_CONNECTION', 'reverb'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    */
    'connections' => [

        'reverb' => [
            'driver'          => 'reverb',
            'key'             => env('REVERB_APP_KEY'),
            'secret'          => env('REVERB_APP_SECRET'),
            'app_id'          => env('REVERB_APP_ID'),
            'options'         => [
                'host'     => env('REVERB_HOST'),
                'port'     => env('REVERB_PORT'),
                'scheme'   => env('REVERB_SCHEME'),
                'useTLS'   => env('REVERB_SCHEME') === 'https',
            ],
            'client_options'  => [
                // For local dev you can disable SSL verification:
                'verify' => false,
            ],
        ],

        'pusher' => [
            'driver'          => 'pusher',
            'key'             => env('PUSHER_APP_KEY'),
            'secret'          => env('PUSHER_APP_SECRET'),
            'app_id'          => env('PUSHER_APP_ID'),
            'options'         => [
                'host'      => env('PUSHER_HOST'),
                'port'      => env('PUSHER_PORT'),
                'scheme'    => env('PUSHER_SCHEME'),
                'useTLS'    => filter_var(env('PUSHER_ENCRYPTED', false), FILTER_VALIDATE_BOOLEAN),
                'encrypted' => filter_var(env('PUSHER_ENCRYPTED', false), FILTER_VALIDATE_BOOLEAN),
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
