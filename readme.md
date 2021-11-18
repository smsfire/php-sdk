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

#### Guide of available parameters on this method
| Param            | Type        | Description                                       | Example             | Required           |
| ---------------- | ----------- | ------------------------------------------------- | ------------------- | :----------------: |
| **to**           | *string*    | Phone at international syntax                     | 5511944556677       | :white_check_mark: |
| **text**         | *string*    | SMS message - Max 765 characters                  | This my message     | :white_check_mark: |
| **from**         | *string*    | Remitent of sms - Max 11 characters               | SMSFIRE             | :x:                |
| **customId**     | *string*    | Set your own id - Max 40 characters               | myId-0001           | :x:                |
| **campaignId**   | *int*       | Merge messages into existent campaign             | 1234                | :x:                |
| **flash**        | *bool*      | Send message on flash mode - Check availability   | true / false        | :x:                |
| **allowReply**   | *bool*      | Allow gateway to capture reply from your messages | true / false        | :x:                |
| **scheduleTime** | *string*    | Schedule message on given datetime - ISO8601      | 2021-11-18 18:00:00 | :x:                |
| **debug**        | *bool*      | Debug API request                                 | true / false        | :x:                |

> [**Additional costs**]
The **allowReply** param can cause additional costs, check with your account manager the details abouts

> **Check availability**
The **flash** param depends of route that were settled on your account as well of each carrier's availability for this feature.

#### Example
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

    /**
     * Pass base64 token on Message instance
     * Check guide table of params
     */
    $messagesService = new Messages($token);
    $response = $messagesService->sendIndividual(
      $to,
      $text,
      $from,
      $customId,
      $campaignId,
      $flash,
      $allowReply,
      $scheduleTime,
      $debug
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
