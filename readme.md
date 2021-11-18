# PHP SDK - SMS
With this SDK you will have access to all public functions of SMS APIs like:
* Send individual sms message
* Send bulk sms messages
* Get message status
* Get inbox messages


# Requirements
* Composer > 2+
* PHP >= 7.1.0
* User and pass ([Register here](https://smsfire.com.br))

# Installation
You can install **php-sms** via composer or by downloading the source.

## Composer
**php-sms** is available on Packagist as the **smsfire/php-sms** package:
```
composer require smsfire/php-sms
```

# Quickstart
The reference of this service can be found [here](https://docs.smsfire.com.br/apis-sms)

## Namespace - Sms\\Message
This namespace will give to you access to few method linked to SMS API services as:
- [sendIndividual()](#send-individual-message) - Send individual sms message
- [sendBulk()](#send-bulk-messages) - Send bulk sms messages
- inbox() - Get your inbox sms messages
- status() - By id or customId you can retrieve message status

### Send individual message
Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#http-simplificado) to check the data response and the details of each parameter of this method.

| Param       | Type        | Description                   | Required           |
| ----------- | ----------- | ----------------------------- | :----------------: |
| to          | *string*    | Phone at international syntax | :white_check_mark: |

```php
//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Messages;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $user = 'myuser'; //Same user that is used to access Dashboard
    $pass = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    //Pass base64 token on Message instance
    $messagesService = new Messages($token);
    $response = $messagesService->sendIndividual(
        '5511999999999',    // [REQUIRED] - Phone on international syntax
        'my message',       // [REQUIRED] - Text to sent
        'smsfire',          // Remitent of message
        'myid-01234',       // Your custom id of message
        1234,               // Merge message into campaign id
        false,              // Set message as false
        true,               // Allow gateway to capture reply from your messages
        '2021-11-17 15:00:00', // Schedule datetime on - ISO8601 - Y-m-d H:i:s
        false               // Debug request
    );

    /**
     * Response as raw text
     * Good to use when Debug option is true
     */
    echo $response;

    //Response with the statusCode of Http response
    echo $response->statusCode();

    //Response as json string
    echo $response->__toJson();

    //Response as object
    print_r($response->__toObject());

    //Response as array
    print_r($response->__toArray());

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
```

### Send bulk messages
Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#rest-json) to check the data response and the details of each parameter of this method.

```php
//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Messages;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $user = 'myuser'; //Same user that is used to access Dashboard
    $pass = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    //Pass base64 token on Message instance
    $messagesService = new Messages($token);
    $response = $messagesService->sendBulk(
        [
          [
            'to' => '5511999999999',
            'text' => 'First message',
            'customId' => 'my-own-id-00001',
            'flash' => true
          ],
          [
            'to' => '5567988888888',
            'text' => 'Second message'
          ]
        ]
    );

    /**
     * Response as raw text
     * Good to use when Debug option is true
     */
    echo $response;

    //Response with the statusCode of Http response
    echo $response->statusCode();

    //Response as json string
    echo $response->__toJson();

    //Response as object
    print_r($response->__toObject());

    //Response as array
    print_r($response->__toArray());

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
