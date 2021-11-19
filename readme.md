# PHP SDK - SMS

[![Latest Stable Version](http://poser.pugx.org/smsfire/php-sms/v)](https://packagist.org/packages/smsfire/php-sms)
[![Total Downloads](http://poser.pugx.org/smsfire/php-sms/downloads)](https://packagist.org/packages/smsfire/php-sms)
[![PHP Version Require](http://poser.pugx.org/smsfire/php-sms/require/php)](https://packagist.org/packages/smsfire/php-sms)

With this SDK you will have access to all public functions of SMS APIs like:  


:white_check_mark: Send individual sms message  
:white_check_mark: Send bulk sms messages  
:white_check_mark: Get inbox messages  
:x: Get message status - *Work in progress*  

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

:speech_balloon: [Messages Service](#namespace---smsfiresmsmessages)  
:mailbox_with_mail: [Inbox Service](#namespace---smsfiresmsinbox)  
:ballot_box_with_check: Status Service

# Namespace - Smsfire\\Sms\\Messages

This namespace allows you to send SMS messages.
- [sendIndividual()](#send-individual-message---sendindividual) - Send individual sms message
- [sendBulk()](#send-bulk-messages---sendbulk) - Send bulk sms messages

> ### Receiving messages (MO)
>
> When you set as **true** the `allowReply` param on [sendIndividual()](#send-individual-message---sendindividual) or [sendBulk()](#send-bulk-messages---sendbulk) messaging methods, your account may have additional costs per each received message. Contact your account manager to know more about it.
>
>
> ### Flash messages - Class 0
>
> The `flash` param depends of route that were settled on your account as well of each carrier's availability for this feature.
Contact your account manager to know more about it.

## Send individual message - sendIndividual()

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#http-simplificado) to check the data response and the details of each parameter of this method.

### Guide of available parameters on this method

| Param            | Type        | Description                                       | Condition               | Required           |
| ---------------- | ----------- | ------------------------------------------------- | ----------------------- | :----------------: |
| **to**           | *string*    | Phone at international syntax                     | Max of 15 characters    | :white_check_mark: |
| **text**         | *string*    | SMS message                                       | Max of 765 characters   | :white_check_mark: |
| **from**         | *string*    | Remitent of sms                                   | Max of 11 characters    | :x:                |
| **customId**     | *string*    | Set your own id                                   | Max of 40 characters    | :x:                |
| **campaignId**   | *int*       | Merge messages into existent campaign             | -                       | :x:                |
| **flash**        | *bool*      | Send message on flash mode - Check availability   | Default: false          | :x:                |
| **allowReply**   | *bool*      | Allow gateway to capture reply from your messages | Default: false          | :x:                |
| **scheduleTime** | *string*    | Schedule message on given datetime                | Datetime ISO8601        | :x:                |
| **debug**        | *bool*      | Debug API request                                 | Default: false          | :x:                |

### Example

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

## Send bulk messages - sendBulk()

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#rest-json) to check the data response and the details of each parameter of this method.

### Guide of available parameters on this method

| Param                         | Type        | Description                                           | Condition                             | Required           |
| ----------------------------- | ----------- | ----------------------------------------------------- | --------------------------------------| :----------------: |
| **destinations**              | *array*     | Array of destinations to message                      | Min of 2 items and Max of 1000 items  | :white_check_mark: |
| **destinations[*].to**        | *string*    | Phone at international syntax                         | Max of 15 characters                  | :white_check_mark: |
| **destinations[*].text**      | *string*    | SMS message                                           | Max of 765 characters                 | :white_check_mark: |
| **destinations[*].from**      | *string*    | Remitent of SMS                                       | Max of 11 characters                  | :x:                |
| **destinations[*].customId**  | *string*    | Set your own id                                       | Max of 40 characters                  | :x:                |
| **destinations[*].flash**     | *bool*      | Send message on flash mode - Check availability       | Default: false                        | :x:                |
| **allowReply**                | *bool*      | Allow gateway to capture reply from your messages     | Default: false                        | :x:                |
| **scheduleTime**              | *string*    | Schedule message on given datetime                    | Datetime ISO8601                      | :x:                |
| **debug**                     | *bool*      | Debug API request                                     | Default: false                        | :x:                |

### Example

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

    //Minimum of two items to use Bulk request
    $destinations = [
      [
        'to' => $firstDestination,
        'text' => $firstMessage,
        'customId' => $firstCustomId,
        'flash' => $flash
      ],
      [
        'to' => $secondDestination,
        'text' => $secondMessage
      ]
    ];

    $response = $messagesService->sendBulk(
        $destinations,
        $campaignId,
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

# Namespace - Smsfire\\Sms\\Inbox

This namespace allows you to get received messages from your sms inbox.

- [getAll()](#get-all-messages---getall) - Get read and unread messages
- [getUnread()](#get-unread-messages---getunread) - Get unread messages

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/inbox) to check the data response and the details of each parameter of this method.

## Get all messages - getAll()

> Due API limitations this method will expose the **last 100 received messages** of your inbox. For more, access the [Portal SMSFire](https://v2.smsfire.com.br) and access it on menu SMS > Inbox
>
> The statusCode 204 will be given when your inbox has no messages. Ref [**204 No Content**](https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Status/204)

### Example
```php

//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Inbox;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $debug = false;    //Debug API request - DEFAULT: false
    $user  = 'myuser'; //Same user that is used to access Dashboard
    $pass  = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    /**
     * Pass base64 token on Inbox instance
     * Check guide table of params
     */
    $inboxServices = new Inbox($token);
    $response = $inboxServices->getAll($debug);

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

    //Handle empty inbox
    if($response->statusCode() === 204) {
      echo "Empty inbox";
    }

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

## Get unread messages - getUnread()

### Example
```php

//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Inbox;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $debug = false;    //Debug API request - DEFAULT: false
    $user  = 'myuser'; //Same user that is used to access Dashboard
    $pass  = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    /**
     * Pass base64 token on Inbox instance
     * Check guide table of params
     */
    $inboxServices = new Inbox($token);
    $response = $inboxServices->getUnread($debug);

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

    //Handle empty inbox
    if($response->statusCode() === 204) {
      echo "Empty inbox";
    }

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

# Namespace - Smsfire\\Exceptions

Custom exceptions that allows you a better error handling.

## SmsfireException

This will be thrown when any SDK required types and data were not meet.

## HttpException

This will be thrown when the core API has some request problem as timeout or bad data for example.
