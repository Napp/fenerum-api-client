<?php

declare(strict_types=1);

namespace Fenerum\Tests;

use Fenerum\Webhooks\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class WebhookHTTPTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake();

        config(['fenerum.webhook_auth_username' => 'myuser']);
        config(['fenerum.webhook_auth_password' => 'mypass']);

        Route::post('webhook', WebhookController::class.'@handle');
    }

    public function test_it_will_handle_auth()
    {
        $response = $this->postJson('/webhook',
            [
                'event' => 'account.created',
                'data' => [
                    'dummy' => 'data'
                ]
            ],
            $this->httpHeaders());
        $response->assertStatus(200);
    }

    public function test_it_will_handle_incorrect_auth()
    {
        $response = $this->postJson('/webhook',
            [
                'event' => 'account.created',
                'data' => [
                    'dummy' => 'data'
                ]
            ],
            []);
        $response->assertStatus(403);
    }


    public function test_validation_fails_when_missing_event()
    {
        $response = $this->postJson('/webhook',
            [
                'data' => [
                    'dummy' => 'data'
                ]
            ],
            $this->httpHeaders());
        $response->assertStatus(422);
    }

    public function test_validation_fails_when_missing_data()
    {
        $response = $this->postJson('/webhook',
            [
                'event' => 'account.created',
            ],
            $this->httpHeaders());
        $response->assertStatus(422);
    }

    public function test_validation_fails_when_invalid_event()
    {
        $response = $this->postJson('/webhook',
            [
                'event' => 'non.existing',
                'data' => [
                    'dummy' => 'data'
                ]
            ],
            $this->httpHeaders());
        $response->assertStatus(404);
    }

    private function httpHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization: Basic '. base64_encode('myuser:mypass'),
            'PHP_AUTH_USER' => 'myuser',
            'PHP_AUTH_PW' =>  'mypass',
        ];
    }

}
