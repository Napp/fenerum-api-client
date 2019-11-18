<?php

declare(strict_types=1);

namespace Fenerum;

use Fenerum\API\Account;
use Fenerum\API\CashFlow;
use Fenerum\API\Contract;
use Fenerum\API\ContractTier;
use Fenerum\API\DraftInvoiceLines;
use Fenerum\API\Invoice;
use Fenerum\API\InvoiceLine;
use Fenerum\API\PaymentCard;
use Fenerum\API\Plan;
use Fenerum\API\Recipient;
use Fenerum\API\Subscription;
use Fenerum\API\Webhook;

/**
 * Class ApiService.
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
     * @return \Fenerum\API\Account
     */
    public function account(): Account
    {
        return new Account($this->client);
    }

    /**
     * @return \Fenerum\API\CashFlow
     */
    public function cashFlow(): CashFlow
    {
        return new CashFlow($this->client);
    }

    /**
     * @return \Fenerum\API\Contract
     */
    public function contract(): Contract
    {
        return new Contract($this->client);
    }

    /**
     * @return \Fenerum\API\ContractTier
     */
    public function contractTier(): ContractTier
    {
        return new ContractTier($this->client);
    }

    /**
     * @return \Fenerum\API\DraftInvoiceLines
     */
    public function draftInvoiceLine(): DraftInvoiceLines
    {
        return new DraftInvoiceLines($this->client);
    }

    /**
     * @return \Fenerum\API\Invoice
     */
    public function invoice(): Invoice
    {
        return new Invoice($this->client);
    }

    /**
     * @return \Fenerum\API\InvoiceLine
     */
    public function invoiceLine(): InvoiceLine
    {
        return new InvoiceLine($this->client);
    }

    /**
     * @return \Fenerum\API\PaymentCard
     */
    public function paymentCard(): PaymentCard
    {
        return new PaymentCard($this->client);
    }

    /**
     * @return \Fenerum\API\Plan
     */
    public function plan(): Plan
    {
        return new Plan($this->client);
    }

    /**
     * @return \Fenerum\API\Recipient
     */
    public function recipient(): Recipient
    {
        return new Recipient($this->client);
    }

    /**
     * @return \Fenerum\API\Subscription
     */
    public function subscription(): Subscription
    {
        return new Subscription($this->client);
    }

    /**
     * @return \Fenerum\API\Webhook
     */
    public function webhook(): Webhook
    {
        return new Webhook($this->client);
    }
}
