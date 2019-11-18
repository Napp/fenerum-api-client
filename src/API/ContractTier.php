<?php

declare(strict_types=1);

namespace Fenerum\API;

class ContractTier extends Base
{
    /**
     * @param string $accountCode
     * @param string $contract
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listContractTiers(string $accountCode, string $contract): ?array
    {
        return $this->client->get('accounts/'.$accountCode.'/contracts/'.$contract.'/tiers/');
    }

    /**
     * @param string $accountCode
     * @param string $contract
     * @param string $id
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getContract(string $accountCode, string $contract, string $id): ?array
    {
        return $this->client->get('accounts/'.$accountCode.'/contracts/'.$contract.'/tiers/'.$id.'/');
    }

    /**
     * @param array $data
     * @param string $accountCode
     * @param string $contract
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createContractTier(array $data, string $accountCode, string $contract): ?array
    {
        $this->validate($data, [
            'minimum_quantity' => 'required|integer',
            'maximum_quantity' => 'integer',
            'discount' => 'string',
            'discount_type' => 'required|string',
            'overall_flat_discount' => 'string',
            'only_apply_to_quantity_above_minimal' => 'boolean',
        ]);

        return $this->client->post('accounts/'.$accountCode.'/contracts/'.$contract.'/tiers/', $data);
    }

    /**
     * @param array $data
     * @param string $accountCode
     * @param string $contract
     * @param string $id
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateContractTier(array $data, string $accountCode, string $contract, string $id): ?array
    {
        $this->validate($data, [
            'minimum_quantity' => 'required|integer',
            'maximum_quantity' => 'integer',
            'discount' => 'string',
            'discount_type' => 'required|string',
            'overall_flat_discount' => 'string',
            'only_apply_to_quantity_above_minimal' => 'boolean',
        ]);

        return $this->client->put('accounts/'.$accountCode.'/contracts/'.$contract.'/tiers/'.$id.'/', $data);
    }

    /**
     * @param string $accountCode
     * @param string $uuid
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteContractTier(string $accountCode, string $contract, string $id): ?array
    {
        return $this->client->delete('accounts/'.$accountCode.'/contracts/'.$contract.'/tiers/'.$id.'/');
    }
}
