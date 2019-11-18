<?php

declare(strict_types=1);

namespace Fenerum\Tests;

use Fenerum\ApiClient;
use Fenerum\ApiService;
use Illuminate\Validation\ValidationException;

class APITest extends TestCase
{
    /** @var ApiService */
    protected $api;

    public function setUp(): void
    {
        parent::setUp();

        config(['fenerum.webhook_auth_username' => 'myuser']);
        config(['fenerum.webhook_auth_password' => 'mypass']);

        $mock = $this->mock(ApiClient::class);
        $mock->shouldReceive('get')->andReturn([
            'dummy' => 'response data',
        ]);
        $this->api = app(ApiService::class);
    }

    public function test_list_accounts()
    {
        $response = $this->api->account()->listAccounts();

        $this->assertEquals([
            'dummy' => 'response data',
        ], $response);
    }

    public function test_create_account_validation_fails()
    {
        $this->expectException(ValidationException::class);

        $this->api->account()->createAccount([
            'company_name' => 'foo INC',
            'billing_same_as_legal' => 'yes please',
        ]);
    }
}
