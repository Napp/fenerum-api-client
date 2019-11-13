<?php

declare(strict_types=1);

namespace Fenerum\Webhooks\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

trait WebhookEvent
{
    use Dispatchable, SerializesModels;

    /** @var string */
    protected $event;

    /** @var array */
    protected $data;

    /**
     * WebhookEvent constructor.
     * @param string $event
     * @param array $data
     */
    public function __construct(string $event, array $data)
    {
        $this->event = $event;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
