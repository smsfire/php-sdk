<?php

namespace Smsfire\Http;

use stdClass;

class Response
{
    private $response;
    private $httpCode;

    /**
     * @param string $data
     * @param string/int @httpcode
     */
    public function __construct($data, $httpcode)
    {
        $this->response = $data;
        $this->httpCode = $httpcode;
    }

    /**
     * Return response as JSON
     * @return string
     */
    public function __toJson(): string
    {
        return $this->response;
    }

    /**
     * Return response as object
     * @return object
     */
    public function __toObject(): stdClass
    {
        return json_decode($this->response);
    }

    /**
     * Return response as array
     * @return array
     */
    public function __toArray(): array
    {
        return json_decode($this->response, true);
    }

    /**
     * Return Http statusCode
     * @return string
     */
    public function statusCode(): string
    {
        return $this->httpCode;
    }

    /**
     * Return raw response data
     * Recommended for debug purposes
     * @return string
     */
    public function __toString(): string
    {
        return '[Response] - ' . $this->response . ' [Http code] - ' . $this->httpCode;
    }
}
