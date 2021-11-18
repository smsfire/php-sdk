<?php

namespace Smsfire\Configurations;

class Constants
{
    const API_V2_HOST = 'https://api-v2.smsfire.com.br';
    const DEFAULT_SMS_REMITENT = 'SMSFIRE';
    const DEFAULT_TIMEZONE = 'America/Sao_Paulo';
    const REQUEST_TIMEOUT = 10;
    const MINIMUM_BULK_REQUEST = 2;

    const SMS_LENGTH = [
      'from' => 11,
      'text' => 765,
      'to' => 15,
      'customId' => 40
    ];

    const SMS_MAP_PARAMETERS = [
      'destinations' => null,
      'to' => null,
      'text' => null,
      'from' => null,
      'customId' => null,
      'campaignId' => null,
      'flash' => null,
      'allowReply' => null,
      'scheduleTime' => null,
      'fractionate' => null,
      'interval' => null,
      'parts' => null
    ];

    const API_ENDPOINT = [
      'sms' => [
        'individual' => '/sms/send/individual',
        'bulk' => '/sms/send/bulk'
      ]
    ];

    const REGEX_RULES = [
      'onlyNumeric' => '/\D/',
      'customId' => '/[^A-Za-z0-9_\-.]/',
      'validBase64' => '/[\x00-\x1F\x7F-\xFF]/'
    ];
}
