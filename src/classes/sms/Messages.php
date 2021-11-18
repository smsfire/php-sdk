<?php

namespace Smsfire\Sms;

use Smsfire\Client;
use Smsfire\Configurations\Constants;
use Smsfire\Traits\Sanitization;
use Smsfire\Traits\Utils;
use Smsfire\Exceptions\SmsfireException;

class Messages extends Client
{
    use Sanitization;
    use Utils;

    private $payload;

    public function __construct(string $token)
    {
        if (empty($token)) {
            throw new SmsfireException('Authentication token is required');
        }

        parent::__construct($token);
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
    public function sendIndividual(string $to, string $text, ?string $from = null, ?string $customId = null, ?int $campaignId = null, bool $flash = false, bool $allowReply = false, ?string $scheduleTime = null, bool $debug = false)
    {
        $apiParameters = self::getSmsApiParametersMap();
        $this->payload = array_filter([
          $apiParameters[1] => $this->smsToParameter($to),
          $apiParameters[2] => $this->smsTextParameter($text),
          $apiParameters[3] => $this->smsFromParameter($from),
          $apiParameters[4] => $this->smsCustomIdParameter($customId),
          $apiParameters[5] => $this->smsCampaignIdParameter($campaignId),
          $apiParameters[6] => $this->smsFlashParameter($flash),
          $apiParameters[7] => $this->smsAllowReplyParameter($allowReply),
          $apiParameters[8] => $this->dateTimeIso8601($scheduleTime)
        ]);

        if (empty($this->payload)) {
            throw new SmsfireException('Empty payload request');
        }

        return $this->request('GET', Constants::API_ENDPOINT['sms']['individual'], $this->payload, $debug);
    }

    /**
     * Send bulk sms messages
     * @param array $destinations
     * @param int $campaignId - Merge message into a existent campaign id - 765 Max length
     * @param boolean $allowReply - Allow gateway to capture message originator
     * @param string $scheduleTime - Define datetime to schedule message - Datetime Iso8601
     * @param boolean $debug - Perform headers debug of API request
     * @return object Response - Handle response of API request
     */
    public function sendBulk(array $destinations = [], ?int $campaignId = null, bool $allowReply = false, ?string $scheduleTime = null, bool $debug = false) {

      $apiParameters = self::getSmsApiParametersMap();
      $parsedDestinations = $this->smsDestinationsParameter($destinations, $apiParameters);

      $this->payload = array_filter([
        $apiParameters[0] => array_map('array_filter', $parsedDestinations),
        $apiParameters[5] => $this->smsCampaignIdParameter($campaignId),
        $apiParameters[7] => $this->smsAllowReplyParameter($allowReply),
        $apiParameters[8] => $this->dateTimeIso8601($scheduleTime)
      ]);

      if (empty($this->payload)) {
          throw new SmsfireException('Empty payload request');
      }

      return $this->request('POST', Constants::API_ENDPOINT['sms']['bulk'], $this->payload, $debug);

    }
}
