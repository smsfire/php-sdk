# PHP SDK - SMS
With this SDK you will have access to all public functions of SMS APIs like:
- Send bulk and individual message
- Get message status
- Get inbox messages


# Requirements
- PHP >= 7.1.0
- User and pass (<a href="https://smsfire.com.br" target="_blank">Register here</a>)

# Installation
You can install **php-sms** via composer or by downloading the source.

## Composer
**php-sms** is available on Packagist as the **smsfire/sdk** package:
```composer
composer require smsfire/sdk
```

# Quickstart
The reference of this service can be found <a href="https://docs.smsfire.com.br/apis-sms" target="_blank">here</a>

## Namespace - Sms\\Message
This namespace will give to you access to few method linked to SMS API services as:
- <a href="#send-individual-message">sendIndividual()</a> - Send individual sms message
- sendBulk() - Send bulk sms messages
- inbox() - Get your inbox sms messages
- status() - By id or customId you can retrieve message status

### Send individual message
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
    $messages = new Messages($token);
    $response = $messages->sendIndividual(
        '5511999999999', //Phone on international syntax
        'my message', //Text to sent
        'smsfire', //Remitent of message
        'myid-01234', //Your custom id of message
        1234, //Merge message into campaign id
        false, //Set message as false
        true, //Allow gateway to capture reply from your messages
        date(DATE_ISO8601), //Schedule datetime on ISO8601  format
        false //Debug request
    );

    /**
     * Response as raw text
     * Good to use when Debug option is true
     */
    $response;

    //Response as json string
    $response->__toJson();

    //Response as object
    $response->__toObject();

    //Response as array
    $response->__toArray();

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
