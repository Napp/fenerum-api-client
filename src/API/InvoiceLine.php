<?php

declare(strict_types=1);

namespace Fenerum\API;

class InvoiceLine extends Base
{
    /**
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function listInvoice(): ?array
    {
        return $this->client->get('invoicelines/');
    }

    /**
     * @param int $id
     * @return array|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getInvoice(int $id): ?array
    {
        return $this->client->get('invoicelines/'.$id.'/');
    }

}
