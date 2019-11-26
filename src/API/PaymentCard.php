<?php

declare(strict_types=1);

namespace Fenerum\API;

class PaymentCard extends Base
{
    /**
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function listPaymentCards(): ?array
    {
        return $this->client->get('paymentscards/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getPaymentCard(string $uuid): ?array
    {
        return $this->client->get('paymentscards/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function createPaymentCard(array $data): ?array
    {
        $this->validate($data, [
            'account' => 'required|string',
            'gateway' => 'required|string',
            'token' => 'required|string',
        ]);

        return $this->client->post('paymentscards/', $data);
    }
}
