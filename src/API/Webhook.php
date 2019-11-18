<?php

declare(strict_types=1);

namespace Fenerum\API;

class Webhook extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listWebhooks(): ?array
    {
        return $this->client->get('webhooks/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWebhook(string $uuid): ?array
    {
        return $this->client->get('webhooks/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createWebhook(array $data): ?array
    {
        $validated = $this->validate($data, [
            'endpoint' => 'required|string',
            'basic_auth_username' => 'string',
            'basic_auth_password' => 'string',
            'enabled' => 'boolean',
            'events' => 'array',
        ]);

        return $this->client->post('webhooks/', $validated);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateWebhook(array $data, string $uuid): ?array
    {
        $validated = $this->validate($data, [
            'endpoint' => 'required|string',
            'basic_auth_username' => 'string',
            'basic_auth_password' => 'string',
            'enabled' => 'boolean',
            'events' => 'array',
        ]);

        return $this->client->put('webhooks/'.$uuid.'/', $validated);
    }
}
