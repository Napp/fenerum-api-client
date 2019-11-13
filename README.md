# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/napp/fenerum-api-client.svg?style=flat-square)](https://packagist.org/packages/napp/fenerum-api-client)
[![Build Status](https://img.shields.io/travis/napp/fenerum-api-client/master.svg?style=flat-square)](https://travis-ci.org/napp/fenerum-api-client)
[![Quality Score](https://img.shields.io/scrutinizer/g/napp/fenerum-api-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/napp/fenerum-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/napp/fenerum-api-client.svg?style=flat-square)](https://packagist.org/packages/napp/fenerum-api-client)


## Installation

You can install the package via composer:

```bash
composer require napp/fenerum-api-client
```

## Installation

1. Add to `.env` -  Fenerum API Token and a user/pass combo to allow Fenerum to post webhook events.

```bash
FENERUM_API_TOKEN=
FENERUM_AUTH_USERNAME=myuser
FENERUM_AUTH_PASSWORD=mypass
```

2. add FenerumServiceProvider to config/app.php

```php
[
    ...
    \Fenerum\FenerumServiceProvider::class,
    ...
]
```

3. Add route to receive webhooks

``` php
Route::post('my-webhook-url', '\Fenerum\Webhooks\Http\Controllers\WebhookController@handle');
```

4. Register events in app/Providers/EventServiceProvider

```php
AccountCreated::class => [
    MyAccountCreatedListener::class
],
AccountUpdated::class => [
    MyAccountUpdatedListener::class
],
CancelSubscription::class => [
    MyCancelSubscriptionListener::class
],
```



### Webhook Events supported

* AccountCreated 
* AccountUpdated
* CancelSubscription
* NewActivity
* NewInvoice
* PaidInvoice
* PlanTermsCreated
* PlanTermsUpdated
* RenewSubscriptionSoon



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Napp](https://github.com/napp)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.