# SagePay
Laravel 5 - Sage Pay Integration

## Usage

### Add service provider
```php
App\Providers\SagePayServiceProvider::class,
```

### Use Facade
```php
use SagePay,
```

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
/* If any config require, config will be store in config/sage.php */
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

return view('payment',compact('paymentArray'));
```

## Check View Part
[payment.blade.php](./payment.blade.php)
