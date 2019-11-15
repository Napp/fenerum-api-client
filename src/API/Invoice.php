<?php

declare(strict_types=1);

namespace Fenerum\API;

class Invoice extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listInvoice(string $uuid): ?array
    {
        return $this->client->get('invoices/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInvoice(string $uuid): ?array
    {
        return $this->client->get('invoices/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateInvoice(array $data, string $uuid): ?array
    {
        $this->validate($data, [
            'kickback_status' => 'string'
        ]);

        return $this->client->patch('invoices/'.$uuid.'/', $data);
    }
}
