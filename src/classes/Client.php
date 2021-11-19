<?php

namespace Smsfire;

use Smsfire\Configurations\Constants;
use Smsfire\Traits\Utils;
use Smsfire\Http\CurlClient;

class Client
{
    use Utils;

    protected $authToken;

    public function __construct(string $token)
    {
        $this->authToken = $this->parseAuthToken($token);
    }
    /**
     * Wraper for request API
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param boolean $debug
     */
    public function request($method, $uri, $payload = null, $debug = false)
    {
        $params = [
            'payload' => $payload,
            'timeout' => Constants::REQUEST_TIMEOUT,
            'debug' => $debug,
            'headers' => [
                'Content-type: application/json',
                'Authorization: Basic '.$this->authToken
            ]
        ];

        $requestClient = new CurlClient();
        $response = $requestClient->request(
            $method,
            $uri,
            $params
        );

        return $response;
    }
}
