<?php

declare(strict_types=1);

namespace Fenerum\API;

class Invoice extends Base
{
    /**
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function listInvoice(): ?array
    {
        return $this->client->get('invoices/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getInvoice(string $uuid): ?array
    {
        return $this->client->get('invoices/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function updateInvoice(array $data, string $uuid): ?array
    {
        $this->validate($data, [
            'kickback_status' => 'string',
        ]);

        return $this->client->patch('invoices/'.$uuid.'/', $data);
    }
}
