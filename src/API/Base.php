<?php

declare(strict_types=1);

namespace Fenerum\API;

use Fenerum\ApiClient;
use Illuminate\Validation\ValidationException;

/**
 * Class Base
 * @see http://docs.fenerum.com/
 */
class Base
{
    /**
     * @var \Fenerum\ApiClient
     */
    protected $client;

    /**
     * @param \Fenerum\ApiClient $client
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|null $payload
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function call(string $method, string $uri, ?array $payload = null): ?array
    {
        return $this->client->request($method, $uri, $payload);
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate(array $data, array $rules): array
    {
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
