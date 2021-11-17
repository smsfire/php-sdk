<?php

namespace Smsfire\Sms;

use Smsfire\Client;
use Smsfire\Traits\Sanitization;
use Smsfire\Configurations\Constants;
use Smsfire\Exceptions\SmsfireException;

class Messages extends Client
{
    use Sanitization;

    private $client;
    private $message;

    public function __construct($token)
    {
        $this->client = parent::__construct($token);
    }

    /**
     * Send individual messages
     * @param string $to - [REQUIRED] - Phone on international syntax - 15 max length
     * @param string $text - [REQUIRED] - Message to be sent - 765 Max length
     * @param string $from - Remitent of message - 11 Max length
     * @param string $customId - Define your own ID - 40 Max length
     * @param int $campaignId - Merge message into a existent campaign id - 765 Max length
     * @param boolean $allowReply - Allow gateway to capture message originator
     * @param string $scheduleTime - Define datetime to schedule message - Datetime Iso8601
     * @param boolean $debug - Perform headers debug of API request
     * @return object Response - Handle response of API request
     */
    public function sendIndividual($to, $text, $from = null, $customId = null, $campaignId = null, $flash = false, $allowReply = false, $scheduleTime = null, $debug = false)
    {
        $apiParameters = $this->getApiParametersMap();
        $this->message = [
        $apiParameters[1] => $this->smsToParameter($to),
        $apiParameters[2] => $this->smsTextParameter($text),
        $apiParameters[3] => $this->smsFromParameter($from),
        $apiParameters[4] => $this->smsCustomIdParameter($customId),
        $apiParameters[5] => $this->smsCampaignIdParameter($campaignId),
        $apiParameters[6] => $this->smsFlashParameter($flash),
        $apiParameters[7] => $this->smsAllowReplyParameter($allowReply),
        $apiParameters[8] => $this->dateTimeIso8601($scheduleTime)
      ];

        $this->message = array_filter($this->message);

        if (empty($this->message)) {
            throw new SmsfireException('Invalid data for individual message');
        }

        return $this->request('GET', Constants::API_ENDPOINT['sms']['individual'], $this->message, $debug);
    }
    /**
     * Get the API parameters
     * @return array
     */
    private function getApiParametersMap(): array
    {
        return array_keys(Constants::SMS_MAP_PARAMETERS);
    }
}
