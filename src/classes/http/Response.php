<?php

namespace Smsfire\Http;

class Response
{
    public function __construct($data, $httpcode)
    {
        $this->response = $data;
        $this->httpCode = $httpcode;
    }

    public function __toJson()
    {
        return $this->response;
    }

    public function __toObject()
    {
        return json_decode($this->response);
    }

    public function __toArray()
    {
        return json_decode($this->response, true);
    }

    public function status()
    {
        return $this->httpCode;
    }

    public function __toString()
    {
        return '[Response] - ' . $this->response . ' [Http code] - ' . $this->httpCode;
    }
}
