<?php

declare(strict_types=1);

namespace Fenerum\API;

class Plan extends Base
{
    /**
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function listPlans(): ?array
    {
        return $this->client->get('plans/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getPlan(string $uuid): ?array
    {
        return $this->client->get('plans/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function calculatePlans(array $data): ?array
    {
        $this->validate($data, [
            'account_country_code' => 'required|string',
            'terms' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        return $this->client->post('plans/calculate/', $data);
    }
}
