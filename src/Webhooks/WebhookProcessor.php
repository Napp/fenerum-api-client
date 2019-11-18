<?php

declare(strict_types=1);

namespace Fenerum\Webhooks;

use Illuminate\Support\Str;

class WebhookProcessor
{
    /**
     * @param string $event
     * @param array $data
     * @return bool
     */
    public static function handle(string $event, array $data): bool
    {
        $class = 'Fenerum\\Webhooks\\Events\\'.Str::studly(str_replace('.', '_', $event));
        if (\class_exists($class)) {
            event(new $class($event, $data));

            return true;
        }

        return false;
    }
}
