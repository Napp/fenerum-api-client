<?php

declare(strict_types=1);

namespace Fenerum\API;

class CashFlow extends Base
{
    /**
     * @param string $month (MM-YYYY)
     * @return array|null
     * @throws \Fenerum\API\Exceptions\FenerumApiException
     */
    public function getCashFlow(string $month): ?array
    {
        return $this->client->get('cash-flow/'.$month.'/');
    }
}
