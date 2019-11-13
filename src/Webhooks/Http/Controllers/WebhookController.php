<?php

declare(strict_types=1);

namespace Fenerum\Webhooks\Http\Controllers;

use Fenerum\Webhooks\Http\Requests\WebhookRequest;
use Illuminate\Support\Str;

class WebhookController
{
    /**
     * @param \Fenerum\Webhooks\Http\Requests\WebhookRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function handle(WebhookRequest $request)
    {
        $class = 'Fenerum\\Webhooks\\Events\\'.Str::studly($request->input('event'));
        if (class_exists($class)) {
            event(new $class($request->input('event'), $request->input('data')));

            return response()->json('OK', 200);
        }

        return response()->json(['error' => 'Webhook not found'], 404);
    }
}
