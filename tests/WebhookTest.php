<?php

declare(strict_types=1);

namespace Fenerum\Tests;

use Fenerum\Webhooks\Events\AccountCreated;
use Fenerum\Webhooks\Events\AccountUpdated;
use Fenerum\Webhooks\Events\CancelSubscription;
use Fenerum\Webhooks\Events\NewActivity;
use Fenerum\Webhooks\Events\NewInvoice;
use Fenerum\Webhooks\Events\PaidInvoice;
use Fenerum\Webhooks\Events\PlanTermsCreated;
use Fenerum\Webhooks\Events\PlanTermsUpdated;
use Fenerum\Webhooks\Events\RenewSubscriptionSoon;
use Fenerum\Webhooks\WebhookProcessor;
use Illuminate\Support\Facades\Event;

class WebhookTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    public function test_it_will_dispatch_account_created_webhook_event()
    {
        WebhookProcessor::handle('account.created', ['dummy' => 'data']);
        Event::assertDispatched(AccountCreated::class);
    }

    public function test_it_will_dispatch_account_updated_webhook_event()
    {
        WebhookProcessor::handle('account.updated', ['dummy' => 'data']);
        Event::assertDispatched(AccountUpdated::class);
    }

    public function test_it_will_dispatch_cancel_subscription_webhook_event()
    {
        WebhookProcessor::handle('cancel_subscription', ['dummy' => 'data']);
        Event::assertDispatched(CancelSubscription::class);
    }

    public function test_it_will_dispatch_new_activity_webhook_event()
    {
        WebhookProcessor::handle('new_activity', ['dummy' => 'data']);
        Event::assertDispatched(NewActivity::class);
    }

    public function test_it_will_dispatch_new_invoice_webhook_event()
    {
        WebhookProcessor::handle('new_invoice', ['dummy' => 'data']);
        Event::assertDispatched(NewInvoice::class);
    }

    public function test_it_will_dispatch_paid_invoice_webhook_event()
    {
        WebhookProcessor::handle('paid_invoice', ['dummy' => 'data']);
        Event::assertDispatched(PaidInvoice::class);
    }

    public function test_it_will_dispatch_plan_terms_created_webhook_event()
    {
        WebhookProcessor::handle('plan_terms.created', ['dummy' => 'data']);
        Event::assertDispatched(PlanTermsCreated::class);
    }

    public function test_it_will_dispatch_plan_terms_updated_webhook_event()
    {
        WebhookProcessor::handle('plan_terms.updated', ['dummy' => 'data']);
        Event::assertDispatched(PlanTermsUpdated::class);
    }

    public function test_it_will_dispatch_renew_subscription_soon_webhook_event()
    {
        WebhookProcessor::handle('renew_subscription_soon', ['dummy' => 'data']);
        Event::assertDispatched(RenewSubscriptionSoon::class);
    }

    public function test_it_will_send_event_data_on_webhook_event()
    {
        WebhookProcessor::handle('renew_subscription_soon', ['dummy' => 'data']);

        Event::assertDispatched(RenewSubscriptionSoon::class, function ($event) {
            $this->assertArrayHasKey('dummy', $event->getData());
            $this->assertEquals('renew_subscription_soon', $event->getEvent());
            $this->assertEquals('data', $event->getData()['dummy']);

            return true;
        });
    }
}
