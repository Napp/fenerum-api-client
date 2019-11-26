<?php

declare(strict_types=1);

namespace Fenerum\API;

class Subscription extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listSubscriptions(): ?array
    {
        return $this->client->get('subscriptions/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscription(string $uuid): ?array
    {
        return $this->client->get('subscriptions/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createSubscription(array $data): ?array
    {
        $this->validate($data, [
            'account' => 'required|string',
            'terms' => 'required|string',
            'collection_method' => 'required|string',
            'start_date' => 'date',
            'quantity' => 'integer',
            'group_on_invoice' => 'boolean',
            'payment_terms' => 'integer',
            'pre_renewal_invoicing' => 'boolean',
            'po_number' => 'string',
            'invoice_supplement' => 'string',
        ]);

        return $this->client->post('subscriptions/', $data);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateSubscription(array $data, string $uuid): ?array
    {
        return $this->client->put('subscriptions/'.$uuid.'/', $data);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function cancelSubscription(array $data, string $uuid): ?array
    {
        $this->validate($data, [
            'cancellation_type' => 'required|string',
        ]);

        return $this->client->post('subscriptions/'.$uuid.'/cancel/', $data);
    }
}
