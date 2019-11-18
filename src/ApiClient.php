<?php

declare(strict_types=1);

namespace Fenerum;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $url): ?array
    {
        return $this->request('GET', $url);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $url, array $data): ?array
    {
        return $this->request('POST', $url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(string $url, array $data): ?array
    {
        return $this->request('PUT', $url, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(string $url, array $data): ?array
    {
        return $this->request('PATCH', $url, $data);
    }

    /**
     * @param string $url
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $uri, $payload = null, array $headers = []): ?array
    {
        if (! $this->isEnabled()) {
            Log::debug('FenerumAPIClient is not enabled. Please review config');

            return null;
        }

        try {
            $response = $this->client->request($method, $uri, [
                'json' => $payload,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (TransferException $exception) {
            $this->handleException($exception, $uri);

            return null;
        }
    }

    /**
     * Send Async Request as we dont want to wait for reply.
     *
     * @param string $method
     * @param string $uri
     * @param array|null $payload
     * @param array $headers
     * @param callable|null $callback
     * @return null
     */
    public function requestAsync(string $method, string $uri, $payload = null, $headers = [], ?callable $callback = null)
    {
        if (! $this->isEnabled()) {
            Log::debug('FenerumAPIClient is not enabled. Please review config');

            return null;
        }

        $promise = $this->client->requestAsync($method, $uri, [
            'json' => $payload,
            'headers' => $headers,
        ])->then(
            static function (ResponseInterface $res) use ($callback) {
                if (null !== $callback) {
                    $callback(json_decode($res->getBody(), true));
                }
            },
            function (TransferException $exception) use ($uri) {
                $this->handleException($exception, $uri);
            }
        );
        $promise->wait();
    }

    /**
     * @param TransferException $exception
     * @param string $uri
     */
    private function handleException(TransferException $exception, string $uri): void
    {
        $response = $exception->getResponse();
        $code = $exception->getCode();
        $body = $exception->getMessage();

        if (null !== $response) {
            $code = $response->getStatusCode();
            $body = $response->getBody();
        }

        Log::error("FenerumAPIClient Response Error: url: {$uri} Response: {$body}. Response code: $code.");

        throw $exception;
    }

    /**
     * Makes sure that all config objects are set before we can use this.
     * @return bool
     */
    private function isEnabled(): bool
    {
        return null !== config('fenerum.base_uri') && null !== config('fenerum.api_token');
    }
}
