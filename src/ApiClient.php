<?php

declare(strict_types=1);

namespace Fenerum;

use Fenerum\API\Exceptions\FenerumApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class ApiClient
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('fenerum.base_uri'),
            'headers' => [
                'Authorization' => 'Token '.config('fenerum.api_token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'timeout'  => 15.0,
        ]);
    }

    /**
     * @param string $url
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function get(string $url): ?array
    {
        return $this->request('GET', $url);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function post(string $url, array $data): ?array
    {
        return $this->request('POST', $url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function put(string $url, array $data): ?array
    {
        return $this->request('PUT', $url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function patch(string $url, array $data): ?array
    {
        return $this->request('PATCH', $url, $data);
    }

    /**
     * @param string $url
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function delete(string $url): ?array
    {
        return $this->request('DELETE', $url);
    }

    /**
     * Send Request.
     *
     * @param string $method
     * @param string $uri
     * @param array|null $payload
     * @param array $headers
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function request(string $method, string $uri, $payload = null, array $headers = []): ?array
    {
        if (! $this->isEnabled()) {
            $this->logger('is not enabled. Please review config');

            return null;
        }

        try {
            $response = $this->client->request($method, $uri, [
                'json' => $payload,
                'headers' => $headers,
            ]);
            $this->logger("Request url: {$uri}", $payload ?? []);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $exception) {
            $this->handleException($exception, $uri);
        }
    }

    /**
     * @param GuzzleException $exception
     * @param string $uri
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    private function handleException(GuzzleException $exception, string $uri): void
    {
        $response = $exception->getResponse();
        $code = $exception->getCode();
        $body = $exception->getMessage();

        if (null !== $response) {
            $code = $response->getStatusCode();
            $body = $response->getBody()->getContents();
        }

        $this->logger("Response Error: url: {$uri} Response: {$body}. Response code: $code.");

        throw new FenerumApiException($body, $code, $exception);
    }

    /**
     * Makes sure that all config objects are set before we can use this.
     * @return bool
     */
    private function isEnabled(): bool
    {
        return null !== config('fenerum.base_uri') && null !== config('fenerum.api_token');
    }

    /**
     * @param string $string
     * @param array|null $context
     */
    private function logger(string $string, ?array $context = []): void
    {
        if (true === config('fenerum.debug')) {
            Log::debug(\get_class($this) . ' ' . $string, $context);
        }
    }
}
