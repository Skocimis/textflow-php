# Textflow PHP client

[![Packagist](https://img.shields.io/packagist/v/textflow/sms-api.svg)](https://packagist.org/packages/textflow/sms-api)
[![Packagist](https://img.shields.io/packagist/dt/textflow/sms-api.svg)](https://packagist.org/packages/textflow/sms-api)

## Documentation
Here you will see just a sample usage of sending an SMS, for more instructions (including methods for user verification) check out our [official PHP documentation](https://docs.textflow.me/php). 

## Installation
`composer require textflow/sms-api`

## Sample Usage

To send an SMS, you have to create an API key using the [Textflow dashboard](https://textflow.me/api). When you register an account, you automatically get an API key with one free SMS which you can send anywhere.

### Just send a message

```php
require_once 'vendor/autoload.php';

$client = new TextFlowClient("YOUR_API_KEY");

$client->send_sms("+38112312341", "SMS body...");
```

### Handle send message request result

```php
$res = $client->send_sms("+38112312341", "SMS body...");

if ($res->ok)
    var_dump($res->data);
else
    var_dump($res->message);
```

### Example result object of the successfully sent message

```json
{
    "ok": true,
    "status": 200,
    "message": "Message sent successfully",
    "data": {
        "to": "+381611231234",
        "content": "Dummy message text...",
        "country_code": "RS",
        "price": 0.05,
        "timestamp": 1674759108881
    }
}
```

### Example result object of the unsuccessfully sent message

```json
{
    "ok": false,
    "status": 404,
    "message": "API key not found"
}
```

## Getting help

If you need help installing or using the library, please check the [FAQ](https://textflow.me) first, and contact us at [support@textflow.me](mailto://support@textflow.me) if you don't find an answer to your question.

If you've found a bug in the API, package or would like new features added, you are also free to contact us!
