# SMSFIRE PHP SDK

[![Version](http://poser.pugx.org/smsfire/php-sdk/version)](https://packagist.org/packages/smsfire/php-sdk)
[![Total Downloads](http://poser.pugx.org/smsfire/php-sdk/downloads)](https://packagist.org/packages/smsfire/php-sdk)
[![PHP Version Require](http://poser.pugx.org/smsfire/php-sdk/require/php)](https://packagist.org/packages/smsfire/php-sdk)

# Requirements

* Composer > 2+
* PHP >= 7.1.0
* User and pass ([Register here](https://smsfire.com.br))

# Installation

You can install **php-sdk** via composer or by downloading the source.

## Composer

**php-sdk** is available on Packagist as the **smsfire/php-sdk** package:
```
composer require smsfire/php-sdk
```

# SMS Services

The reference of this service can be found [here](https://docs.smsfire.com.br/apis-sms)

:speech_balloon: [Messages Service](#namespace---smsfiresmsmessages)  
:mailbox_with_mail: [Inbox Service](#namespace---smsfiresmsinbox)  
:ballot_box_with_check: [Status Service](#namespace---smsfiresmsstatus)

## Namespace - Smsfire\\Sms\\Messages

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

### Send individual message - sendIndividual()

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#http-simplificado) to check the data response and the details of each parameter of this method.

#### Guide of available parameters on this method

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

### Send bulk messages - sendBulk()

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/enviar-mensagem#rest-json) to check the data response and the details of each parameter of this method.

#### Guide of available parameters on this method

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
        'to' => '5511944556677',
        'text' => 'My first message',
        'customId' => 'abc-00001',
        'flash' => true
      ],
      [
        'to' => '5565988887777',
        'text' => 'My second message'
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

## Namespace - Smsfire\\Sms\\Inbox

This namespace allows you to get received messages from your sms inbox.

- [getAll()](#get-all-messages---getall) - Get read and unread messages
- [getUnread()](#get-unread-messages---getunread) - Get unread messages

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/inbox) to check the data response and the details of each parameter of this method.

> #### The statusCode 204 will be given when your inbox has no messages. [**REF. 204 No Content**](https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Status/204)

### Get all messages - getAll()

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

> Due API limitations this method will expose the **last 100 received messages** of your inbox. For more, access the [Portal SMSFire](https://v2.smsfire.com.br) and access it on menu SMS > Inbox

### Get unread messages - getUnread()

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

## Namespace - Smsfire\\Sms\\Status

This namespace allows you to get messages status by `id` or given `customId`

- [messageIds()](#get-messages-status-by-id---messageids) - Get messages status by id
- [customIds()](#get-messages-status-by-customid---customids) - Get messages status by customId

Access the [reference docs](https://docs.smsfire.com.br/apis-sms/consulta-status) to check the data response and the details of each parameter of this method.

> #### The statusCode 204 will be given when given id or customId does not exist. [**REF. 204 No Content**](https://developer.mozilla.org/pt-BR/docs/Web/HTTP/Status/204)

### Get messages status by id - messageIds()

#### Guide of available parameters on this method

| Param                         | Type        | Description                                           | Condition                             | Required           |
| ----------------------------- | ----------- | ----------------------------------------------------- | --------------------------------------| :----------------: |
| **ids**                       | *string*    | String with messages ids (Comma separated)            | Min of 1 and max of 200 Ids           | :white_check_mark: |
| **debug**                     | *bool*      | Debug API request                                     | Default: false                        | :x:                |

### Example
```php

//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Status;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $user  = 'myuser'; //Same user that is used to access Dashboard
    $pass  = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    /**
     * Pass base64 token on Status instance
     * Check guide table of params
     */
    $messagesStatus = new Status($token);
    $ids = "000001,000002,000003"; //Messages ids - Comma separated
    $response = $messagesStatus->messageIds($ids, $debug);

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

    //Handle empty result
    if($response->statusCode() === 204) {
      echo "Message id does not exist";
    }

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

> Due API limitations this method will accepts the maximum of **200 messages ids**. For more, access the [Portal SMSFire](https://v2.smsfire.com.br) and access it on menu SMS > Reports

### Get messages status by customId - customIds()

#### Guide of available parameters on this method

| Param                         | Type        | Description                                           | Condition                             | Required           |
| ----------------------------- | ----------- | ----------------------------------------------------- | --------------------------------------| :----------------: |
| **customIds**                 | *string*    | String with custom id of messages (Comma separated)   | Min of 1 and max of 200 custom ids    | :white_check_mark: |
| **debug**                     | *bool*      | Debug API request                                     | Default: false                        | :x:                |

### Example
```php

//Load composer autoload file
require './vendor/autoload.php';

use Smsfire\Sms\Status;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

try {

    $user  = 'myuser'; //Same user that is used to access Dashboard
    $pass  = 'mypass'; //Same password that is used to access Dashboard
    $token = base64_encode("{$user}:{$pass}");   

    /**
     * Pass base64 token on Status instance
     * Check guide table of params
     */
    $messagesStatus = new Status($token);
    $customIds = "myid0001,myid000002,myid000003"; //Custom ids - Comma separated
    $response = $messagesStatus->customIds($customIds, $debug);

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

    //Handle empty result
    if($response->statusCode() === 204) {
      echo "Custom id does not exist";
    }

} catch (SmsfireException $e) {  
    echo $e->getMessage();
} catch (HttpException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}

```

## Namespace - Smsfire\\Exceptions

Custom exceptions that allows you a better error handling.

### SmsfireException

This will be thrown when any SDK required types and data were not meet.

### HttpException

This will be thrown when the core API has some request problem as timeout or bad data for example.
