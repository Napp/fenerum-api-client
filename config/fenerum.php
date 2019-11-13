<?php

declare(strict_types=1) {
    return [
    /*
     * The base URI for the Fenerum API
     * Please dont change it if not needed
     */
    'base_uri' => env('FENERUM_BASE_URI', 'https://app.fenerum.com/api/v1/'),

    /*
     * API token for auth API requests
     */
    'api_token' => env('FENERUM_API_TOKEN'),

    /*
     * Webhooks uses Basic Auth for Fenerum to be authed in your app
     */
    'webhook_auth_username' => env('FENERUM_AUTH_USERNAME'),
    'webhook_auth_password' => env('FENERUM_AUTH_PASSWORD'),
];
}
