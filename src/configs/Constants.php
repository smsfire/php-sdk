<?php

namespace Smsfire\Configurations;

class Constants {

  const API_V2_HOST = 'https://api-v2.smsfire.com.br';
  const DEFAULT_SMS_REMITENT = 'SMSFIRE';

  const SMS_LENGTH = [
    'from' => 11,
    'text' => 765,
    'to' => 15,
    'customId' => 40
  ];

  const REGEX_RULES = [
    'onlyNumeric' => '/\D/',
    'customId' => '/[^A-Za-z0-9_\-.]/',
    'validBase64' => '/[\x00-\x1F\x7F-\xFF]/'
  ];

}
