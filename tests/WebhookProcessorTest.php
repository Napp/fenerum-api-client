<?php

declare(strict_types=1);

namespace Fenerum\Tests;

use Fenerum\Webhooks\Events\NewActivity;
use Fenerum\Webhooks\WebhookProcessor;
use Illuminate\Support\Facades\Event;

class WebhookProcessorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function it_will_an_existing_webhook_event()
    {
        $result = WebhookProcessor::handle('new_activity', [
            'dummy' => 'data',
        ]);

        Event::assertDispatched(NewActivity::class);
        $this->assertTrue($result);
    }

    /** @test */
    public function it_will_not_fire_non_existing_webhook_event()
    {
        $result = WebhookProcessor::handle('non_existing', [
            'dummy' => 'data',
        ]);

        $this->assertFalse($result);
    }
}
