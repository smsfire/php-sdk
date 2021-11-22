<?php

namespace Smsfire\Configurations;

class Constants
{
    public const API_V2_HOST = 'https://api-v2.smsfire.com.br';
    public const DEFAULT_SMS_REMITENT = 'SMSFIRE';
    public const DEFAULT_TIMEZONE = 'America/Sao_Paulo';
    public const REQUEST_TIMEOUT = 10;
    public const MINIMUM_BULK_REQUEST = 2;
    public const INIT_STATUSCODE_ERROR = 300;

    public const SMS_LENGTH = [
        'from' => 11,
        'text' => 765,
        'to' => 15,
        'customId' => 40
    ];

    public const SMS_MAP_PARAMETERS = [
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
        'parts' => null,
        'ids' => null,
        'customIds' => null
    ];

    public const API_ENDPOINT = [
        'sms' => [
            'individual' => '/sms/send/individual',
            'bulk' => '/sms/send/bulk',
            'status' => '/sms/status/search',
            'inbox' => [
                'new' => '/sms/inbox/new',
                'all' => '/sms/inbox/all'
            ],
        ]
    ];

    public const REGEX_RULES = [
        'onlyNumeric' => '/\D/',
        'customId' => '/[^A-Za-z0-9_\-.]/',
        'validBase64' => '/[\x00-\x1F\x7F-\xFF]/'
    ];
}
