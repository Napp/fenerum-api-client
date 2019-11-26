<?php

declare(strict_types=1);

namespace Fenerum\API;

use Fenerum\API\Exceptions\FenerumValidationException;
use Fenerum\ApiClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class Base.
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
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function call(string $method, string $uri, ?array $payload = null): ?array
    {
        return $this->client->request($method, $uri, $payload);
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    protected function validate(array $data, array $rules): array
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->logger($validator->errors()->toJson());

            throw new FenerumValidationException($validator);
        }

        return $validator->validated();
    }

    /**
     * @param string $string
     */
    private function logger(string $string): void
    {
        if (true === config('fenerum.debug')) {
            Log::debug(\get_class($this) . ' ' . $string);
        }
    }
}
