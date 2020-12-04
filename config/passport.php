<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Personal access client id
    |--------------------------------------------------------------------------
    |
    | Can be checked in db
    |
    */
    'personal_client_id' => env('PASSPORT_PERSONAL_CLIENT_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Personal access client secret
    |--------------------------------------------------------------------------
    |
    | Can be checked in db
    |
    */
    'personal_client_secret' => env('PASSPORT_PERSONAL_CLIENT_SECRET', null),

    /*
    |--------------------------------------------------------------------------
    | Password grant access client id
    |--------------------------------------------------------------------------
    |
    | Can be checked in db
    |
    */
    'password_client_id' => env('PASSPORT_PASSWORD_CLIENT_ID', null),

    /*
    |--------------------------------------------------------------------------
    | Password grant access client secret
    |--------------------------------------------------------------------------
    |
    | Can be checked in db
    |
    */
    'password_client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET', null),
];
