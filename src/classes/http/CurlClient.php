<?php

namespace Smsfire\Http;

use Smsfire\Configurations\Constants;
use Smsfire\Http\Client;
use Smsfire\Http\Response;
use Smsfire\Traits\Utils;
use Smsfire\Exceptions\HttpException;

class CurlClient implements Client
{
    use Utils;

    private $curl;
    private $curlOptions = [];

    public function __construct()
    {
        $this->curl = curl_init();
    }
    /**
     * Perform request to given API service
     * @param string $method - POST/GET methods available
     * @param string $uri - API service uri
     * @param array $params
     * @return Smsfire\Http\Response
     */
    public function request(string $method, string $uri, array ...$params): Response
    {
        $parsedParams = self::parseRequestData($params);
        $this->setCurlOptions($method, $uri, $parsedParams['headers'], $parsedParams['payload'], $parsedParams['timeout'], $parsedParams['debug']);
        $response = curl_exec($this->curl);

        if (!$response) {
            throw new HttpException(curl_error($this->curl), curl_errno($this->curl));
        }

        $this->response = new Response($response, curl_getinfo($this->curl, CURLINFO_HTTP_CODE));
        return $this->response;
    }
    /**
     * Set curl options
     * According request method
     * @param string $method - POST/GET
     * @param string $uri - Uri service of API
     * @param array $headers - Required headers
     * @param array $payload - Data payload to request
     * @param int $timeout - request timeout
     * @param bool $debug - Flag of debug mode
     * @return bool
     */
    private function setCurlOptions(string $method, string $uri, array $headers, array $payload, int $timeout, bool $debug): bool
    {
        if ($method === 'GET') {
            $queryString = '?'.http_build_query($payload);
            $this->curlOptions += [
              CURLOPT_HTTPGET => true
            ];
        }

        if ($method === 'POST') {
            $postFields = json_encode($payload);
        }

        $this->curlOptions += [
            CURLOPT_URL => Constants::API_V2_HOST . $uri. ($queryString ?? false),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => ($postFields ?? false),
            CURLOPT_HEADER => $debug,
            CURLOPT_HTTPHEADER => $headers
        ];

        return curl_setopt_array($this->curl, $this->curlOptions);
    }
}
