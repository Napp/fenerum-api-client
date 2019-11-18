<?php

declare(strict_types=1);

namespace Fenerum\API;

class Contract extends Base
{
    /**
     * @param string $accountCode
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listContracts(string $accountCode): ?array
    {
        return $this->client->get('accounts/'.$accountCode.'/contracts/');
    }

    /**
     * @param string $accountCode
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContract(string $accountCode, string $uuid): ?array
    {
        return $this->client->get('accounts/'.$accountCode.'/contracts/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @param string $accountCode
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createContract(array $data, string $accountCode): ?array
    {
        $this->validate($data, [
            'plan_terms' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'commitment_length' => 'required|integer',
            'exclusive_tiers' => 'boolean',
        ]);

        return $this->client->post('accounts/'.$accountCode.'/contracts/', $data);
    }

    /**
     * @param array $data
     * @param string $accountCode
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateContract(array $data, string $accountCode, string $uuid): ?array
    {
        $this->validate($data, [
            'plan_terms' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'commitment_length' => 'required|integer',
            'exclusive_tiers' => 'boolean',
        ]);

        return $this->client->put('accounts/'.$accountCode.'/contracts/'.$uuid.'/', $data);
    }

    /**
     * @param string $accountCode
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteContract(string $accountCode, string $uuid): ?array
    {
        return $this->client->delete('accounts/'.$accountCode.'/contracts/'.$uuid.'/');
    }
}
