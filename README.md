# SagePay
Laravel 5 - Sage Pay Integration

### Installation
Use Git Clone .
```
git clone https://github.com/vijaybajrot/sagepay
```


## Usage

### Add service provider
```php
App\Providers\SagePayServiceProvider::class,
```

### Use Facade
```php
use SagePay,
```

#### Update Config in config/sage.php

## Code

```php
$sagePay = SagePay::create(array(
    'fullUrl' => url('/application/fullUrl'),
    'currency' => "GBP",
));

$sagePay->addBasketItems(array(
    "title" => "Product First",
    'amount' => "10"
));

/* Overwrite config */
$sagePay->setConfig("formSuccessUrl",'application/successUrl');
$sagePay->setConfig("formFailureUrl",'application/successUrl');

$sagePay->billing(array(
    "firstname"=> "Customer first name",
    "lastname"=> "Customer last name",
    "email"=> "Customer email",
    "address1"=> "Address line 1",
    "city" => "City",
    "postcode" => "Postcode",
    "country" => "Country code",
    "state" => "State",
    "phone" => "Phone no.", //optional
));

$paymentArray = $sagePay->processPayment();

return view('payment',$paymentArray);
```

## Check View Part
[payment.blade.php](./payment.blade.php)

### Add autoload settings in **composer.json**, if you are facing problem with namespaces.
```json
"psr-4": {
    "App\\": "app/",
    "Tests\\": "tests/",
    "Services\\": "services/"
},
```
