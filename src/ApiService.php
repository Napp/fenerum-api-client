<?php

declare(strict_types=1);

namespace Fenerum;

use Illuminate\Validation\ValidationException;

/**
 * Class ApiService
 * @package Fenerum
 * @see http://docs.fenerum.com/
 */
class ApiService
{
    /**
     * @var \Fenerum\ApiClient
     */
    protected $client;

    /**
     * ApiService constructor.
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
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listAccounts(): ?array
    {
        return $this->client->get('accounts');
    }

    /**
     * @param string $code
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccount(string $code): ?array
    {
        return $this->client->get('accounts/'.$code);
    }

    /**
     * @see http://docs.fenerum.com/#operation/accounts_create
     *
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createAccount(array $data): ?array
    {
        $this->validate($data, [
            'company_name' => 'required|string|max:128',
            'code' => 'required|string|max:128',
            'legal_address' => 'required|string',
            'legal_zipcode' => 'required|string',
            'legal_city' => 'required|string',
            'legal_country' => 'required|string',
        ]);

        return $this->client->post('accounts', $data);
    }

    /**
     * @param array $data
     * @param string $code
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateAccount(array $data, string $code): ?array
    {
        $this->validate($data, [
            'company_name' => 'required|string|max:128',
            'code' => 'required|string|max:128',
            'legal_address' => 'required|string',
            'legal_zipcode' => 'required|string',
            'legal_city' => 'required|string',
            'legal_country' => 'required|string',
        ]);

        return $this->client->put('accounts/'.$code, $data);
    }

    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listSubscriptions(): ?array
    {
        return $this->client->get('subscriptions');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscription(string $uuid): ?array
    {
        return $this->client->get('subscriptions/'.$uuid);
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
        ]);

        return $this->client->post('subscriptions', $data);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateSubscription(array $data, string $uuid): ?array
    {
        return $this->client->put('subscriptions/'.$uuid, $data);
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
            'cancellation_type' => 'required|string'
        ]);

        return $this->client->put('subscriptions/'.$uuid.'/cancel', $data);
    }

    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listPlans(): ?array
    {
        return $this->client->get('plans');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPlan(string $uuid): ?array
    {
        return $this->client->get('plans/'.$uuid);
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function calculatePlans(array $data): ?array
    {
        $this->validate($data, [
            'account_country_code' => 'required|string',
            'terms' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        return $this->client->post('plans/calculate', $data);
    }

    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listPaymentCards(): ?array
    {
        return $this->client->get('paymentscards');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPaymentCard(string $uuid): ?array
    {
        return $this->client->get('paymentscards/'.$uuid);
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

        return $this->client->post('paymentscards', $data);
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInvoice(string $uuid): ?array
    {
        return $this->client->get('invoices/'.$uuid);
    }


    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecipient(string $uuid): ?array
    {
        return $this->client->get('recipients/'.$uuid);
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
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

        return $this->client->post('recipients', $data);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
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

        return $this->client->put('recipients/'.$uuid, $data);
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteRecipient(string $uuid): ?array
    {
        return $this->client->delete('recipients/'.$uuid);
    }

    /**
     * @param array $data
     * @param array $rules
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validate(array $data, array $rules): array
    {
        $validator = \Illuminate\Support\Facades\Validator::make($data, $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
