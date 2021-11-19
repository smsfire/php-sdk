<?php

namespace Smsfire\Sms;

use Smsfire\Client;
use Smsfire\Configurations\Constants;
use Smsfire\Exceptions\SmsfireException;

class Inbox extends Client
{
    public function __construct(string $token)
    {
        if (empty($token)) {
            throw new SmsfireException('Authentication token is required');
        }

        parent::__construct($token);
    }

    /**
     * Get just unread messages by API CORE
     * @param bool $debug
     * @return object
     */
    public function getUnread($debug = false)
    {
        return $this->request('GET', Constants::API_ENDPOINT['sms']['inbox']['new'], null, $debug);
    }

    /**
     * Get the last 100 messages from sms inbox
     * @param bool $debug
     * @return object
     */
    public function getAll($debug = false)
    {
        return $this->request('GET', Constants::API_ENDPOINT['sms']['inbox']['all'], null, $debug);
    }
}
