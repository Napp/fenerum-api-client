# API Client for Fenerum

[![Latest Version on Packagist](https://img.shields.io/packagist/v/napp/fenerum-api-client.svg?style=flat-square)](https://packagist.org/packages/napp/fenerum-api-client)
[![Build Status](https://img.shields.io/travis/napp/fenerum-api-client/master.svg?style=flat-square)](https://travis-ci.org/napp/fenerum-api-client)
[![Quality Score](https://img.shields.io/scrutinizer/g/napp/fenerum-api-client.svg?style=flat-square)](https://scrutinizer-ci.com/g/napp/fenerum-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/napp/fenerum-api-client.svg?style=flat-square)](https://packagist.org/packages/napp/fenerum-api-client)
[![Code Coverage](https://scrutinizer-ci.com/g/Napp/fenerum-api-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Napp/fenerum-api-client/?branch=master)


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


## Usage


```php

// use DI to resolve dependencies
$accounts = app(\Fenerum\ApiService::class)->account();

// or without DI
$client = new \Fenerum\ApiClient();
$fenerum = new \Fenerum\ApiService($client);
$accounts = $fenerum->account();
```


### Examples 

#### Get accounts

```php
use Fenerum\ApiService;

$accounts = app(ApiService::class)->account()->listAccounts();
```

#### Update Subscription - User Seats

```php
// find account with id "1234"
$myAccount = $fenerum->account()->getAccount('1234');

// get the first subscription
$subId = $myAccount['subscription_set'][0]['uuid'];

// update subscription user seat count
$updatedSubscription = $fenerum->subscription()->updateSubscription([
    'quantity' => 59
], $subId);

```

#### Create account and add subscription (simple version)

```php
/** @var \Fenerum\ApiService $fenerum */
$fenerum = app(\Fenerum\ApiService::class);

$localAccountCode = '12345678';
$planTermId = 'c82a888e-2149-4b3c-8e14-ff5086e49417';

// create an account
$fenerum->account()->createAccount([
    'company_name' => 'Foo Bar Inc',
    'code' => $localAccountCode,
    'legal_address' => 'Road 123',
    'legal_zipcode' => '90210',
    'legal_city' => 'Hollywood',
    'legal_country' => 'US',
    'billing_same_as_legal' => true,
    'language' => 'en',
    'legal_vat_number' => 'US22223344',
]);

// add subscription to the account
$result = $fenerum->subscription()->createSubscription([
   'account' => $localAccountCode,
   'terms' => $planTermId,
   'collection_method' => 'invoice',
   'start_date' => now()->endOfMonth()->toIso8601String(),
   'payment_terms' => 14
]);
```

#### Create account and add recipient, contract, discount and a subscription (advanced version)

```php
/** @var \Fenerum\ApiService $fenerum */
$fenerum = app(\Fenerum\ApiService::class);

$localAccountCode = '12345678';
$planTermId = 'c82a888e-2149-4b3c-8e14-ff5086e49417';

// create an account
$account = $fenerum->account()->createAccount([
    'company_name' => 'Foo Bar Inc',
    'code' => $localAccountCode,
    'legal_address' => 'Road 123',
    'legal_zipcode' => '90210',
    'legal_city' => 'Hollywood',
    'legal_country' => 'US',
    'billing_same_as_legal' => true,
    'language' => 'en',
    'legal_vat_number' => 'US22223344',
]);

// create a recipient
$fenerum->recipient()->createRecipient([
    'account' => $account['uuid'],
    'name' => 'John Doe',
    'email' => 'john@doe.com',
    'receive_invoice' => true,
    'receive_payment_confirmation' => true,
    'receive_subscription_notifications' => true,
]);

// assign a 24 month contract to the account
$contract = $fenerum->contract()->createContract([
    'plan_terms' => $planTermId,
    'start_date' => now()->startOfDay()->toIso8601String(),
    'commitment_length' => 24
], $localAccountCode);

// add 10% discounting
$fenerum->contractTier()->createContractTier([
    'minimum_quantity' => 1,
    'discount' => '10',
    'discount_type' => 'percent',
], $localAccountCode, $contract['uuid']);

// add subscription to the account
$result = $fenerum->subscription()->createSubscription([
   'account' => $localAccountCode,
   'terms' => $planTermId,
   'collection_method' => 'invoice',
   'start_date' => now()->endOfMonth()->toIso8601String(),
   'payment_terms' => 14
]);
```


#### Download invoice

```php
$invoice = app(\Fenerum\ApiService::class)
            ->invoice()
            ->getInvoice('24260f57-f190-4cfa-a2a0-d8a8d827bda8');

$filePath = public_path('invoice_'.$invoice['invoice_number'].'.pdf');
file_put_contents($filePath, base64_decode($invoice['pdf_base64']));

return response()->download($filePath)->deleteFileAfterSend(true);

```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Napp](https://github.com/napp)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
