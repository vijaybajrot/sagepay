# SagePay
Laravel 5 - Sage Pay Integration

### Development in Under Way

## Example

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
```
