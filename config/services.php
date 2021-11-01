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

    /**
     * Kaltura
     *  
     * We use the keys via .env file which load
     * the relevant variables per environment instead of keeping not relevant values in git 
     * and it is also hide private values from the public
     */
    'kaltura' => [
        'secret' => env('KALTURA_SECRET'),
        'user_id' => env('KALTURA_USER_ID'),
        'partner_id' => env('KALTURA_PARTNER_ID'),        
        'service_url' => env('KALTURA_SERVICE_URL'),        
        'ks' => env('KALTURA_KS'),        
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],



];
