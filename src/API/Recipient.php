<?php

declare(strict_types=1);

namespace Fenerum\API;

class Recipient extends Base
{
    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getRecipient(string $uuid): ?array
    {
        return $this->client->get('recipients/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function createRecipient(array $data): ?array
    {
        $this->validate($data, [
            'account' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'receive_invoice' => 'required|boolean',
            'receive_payment_confirmation' => 'required|boolean',
            'receive_subscription_notifications' => 'required|boolean',
        ]);

        return $this->client->post('recipients/', $data);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function updateRecipient(array $data, string $uuid): ?array
    {
        $this->validate($data, [
            'account' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'receive_invoice' => 'required|boolean',
            'receive_payment_confirmation' => 'required|boolean',
            'receive_subscription_notifications' => 'required|boolean',
        ]);

        return $this->client->put('recipients/'.$uuid.'/', $data);
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function deleteRecipient(string $uuid): ?array
    {
        return $this->client->delete('recipients/'.$uuid.'/');
    }
}
