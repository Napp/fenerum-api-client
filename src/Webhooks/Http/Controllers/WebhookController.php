<?php

declare(strict_types=1);

namespace Fenerum\Webhooks\Http\Controllers;

use Fenerum\Webhooks\Http\Requests\WebhookRequest;
use Fenerum\Webhooks\WebhookProcessor;

class WebhookController
{
    /**
     * @param \Fenerum\Webhooks\Http\Requests\WebhookRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function handle(WebhookRequest $request)
    {
        $result = WebhookProcessor::handle($request->input('event'), $request->input('data'));
        if ($result) {
            return response()->json('OK', 200);
        }

        return response()->json(['error' => 'Webhook not found'], 404);
    }
}
