<?php

declare(strict_types=1);

namespace Fenerum\API;

class DraftInvoiceLines extends Base
{
    /**
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function listDraftInvoiceLines(): ?array
    {
        return $this->client->get('draftinvoicelines/');
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getDraftInvoiceLine(string $uuid): ?array
    {
        return $this->client->get('draftinvoicelines/'.$uuid.'/');
    }

    /**
     * @param array $data
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function createDraftInvoiceLine(array $data): ?array
    {
        $validated = $this->validate($data, [
            'account' => 'required|string',
            'description' => 'required|string',
            'vat_type' => 'required|string',
            'collect_vat' => 'boolean',
            'date_from' => 'date',
            'date_to' => 'date',
            'price' => 'string',
            'quantity' => 'string',
            'currency' => 'string',
            'include_in_next_renewal_invoice' => 'boolean',
            'revenue_group' => 'string',
        ]);

        return $this->client->post('draftinvoicelines/', $validated);
    }

    /**
     * @param array $data
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     * @throws \Fenerum\API\Exceptions\FenerumValidationException
     */
    public function updateDraftInvoiceLine(array $data, string $uuid): ?array
    {
        $validated = $this->validate($data, [
            'account' => 'required|string',
            'description' => 'required|string',
            'vat_type' => 'required|string',
            'collect_vat' => 'boolean',
            'date_from' => 'date',
            'date_to' => 'date',
            'price' => 'string',
            'quantity' => 'string',
            'currency' => 'string',
            'include_in_next_renewal_invoice' => 'boolean',
            'revenue_group' => 'string',
        ]);

        return $this->client->put('draftinvoicelines/'.$uuid.'/', $validated);
    }

    /**
     * @param string $uuid
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function deleteDraftInvoiceLine(string $uuid): ?array
    {
        return $this->client->delete('draftinvoicelines/'.$uuid.'/');
    }
}
