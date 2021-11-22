<?php

namespace Smsfire\Sms;

use Smsfire\Client;
use Smsfire\Configurations\Constants;
use Smsfire\Traits\Sanitization;
use Smsfire\Traits\Utils;
use Smsfire\Exceptions\SmsfireException;

class Status extends Client
{
    use Sanitization;
    use Utils;

    public function __construct(string $token)
    {
        if (empty($token)) {
            throw new SmsfireException('Authentication token is required');
        }

        parent::__construct($token);
    }

    /**
     * Get messages status by customIds
     * @param string $ids
     * @param bool $debug
     * @return object
     */
    public function messageIds($ids, $debug = false)
    {
        $apiParameters = self::getSmsApiParametersMap();
        $parsedMessageIds = self::smsMessageIdsParameter($ids);

        $this->payload[$apiParameters[12]] = $parsedMessageIds;
        return $this->request('POST', Constants::API_ENDPOINT['sms']['status'], $this->payload, $debug);
    }

    /**
     * Get messages status by customIds
     * @param string $ids
     * @param bool $debug
     * @return object
     */
    public function customIds($ids, $debug = false)
    {
        $apiParameters = self::getSmsApiParametersMap();
        $parsedMessageIds = self::smscustomIdsParameter($ids);

        $this->payload[$apiParameters[13]] = $parsedMessageIds;
        return $this->request('POST', Constants::API_ENDPOINT['sms']['status'], $this->payload, $debug);
    }
}
