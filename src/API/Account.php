<?php

declare(strict_types=1);

namespace Fenerum\API;

class Account extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listAccounts(): ?array
    {
        return $this->client->get('accounts/');
    }

    /**
     * @param string $code
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAccount(string $code): ?array
    {
        return $this->client->get('accounts/'.$code.'/');
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

        return $this->client->post('accounts/', $data);
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

        return $this->client->put('accounts/'.$code.'/', $data);
    }
}
