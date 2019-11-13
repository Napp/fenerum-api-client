<?php

declare(strict_types=1);

namespace Fenerum\Webhooks\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebhookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return config('fenerum.webhook_auth_username') === $this->getUser() &&
               config('fenerum.webhook_auth_password') === $this->getPassword();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'event' => ['required', 'string'],
            'data' => ['required', 'array'],
        ];
    }
}
