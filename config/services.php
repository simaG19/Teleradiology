<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'stripe' => [
    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),
    ],

   'chapa' => [
        // read from CHAPA_SECRET_KEY for clarity; also provide legacy 'secret'
        'secret_key' => env('CHAPA_SECRET_KEY'),
        'secret' => env('CHAPA_SECRET', env('CHAPA_SECRET_KEY')), // backward compatible
        'public' => env('CHAPA_PUBLIC_KEY'),
        'base_url' => env('CHAPA_BASE_URL', 'https://api.chapa.co/v1'),
        'env' => env('CHAPA_ENV', 'test'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
