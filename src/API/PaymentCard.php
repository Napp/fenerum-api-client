<?php

declare(strict_types=1);

namespace Fenerum\API;

class PaymentCard extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listPaymentCards(): ?array
    {
        return $this->client->get('paymentscards/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPaymentCard(string $uuid): ?array
    {
        return $this->client->get('paymentscards/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
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
