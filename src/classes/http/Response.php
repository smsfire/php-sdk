<?php

namespace Smsfire\Http;

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
     * @return string|null
     */
    public function __toJson(): ?string
    {
        return $this->response;
    }

    /**
     * Return response as object
     * @return object|null
     */
    public function __toObject(): ?stdClass
    {
        return json_decode($this->response);
    }

    /**
     * Return response as array
     * @return array|null
     */
    public function __toArray(): ?array
    {
        return json_decode($this->response, true);
    }

    /**
     * Return Http statusCode
     * @return int
     */
    public function statusCode(): int
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
