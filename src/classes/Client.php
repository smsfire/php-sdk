<?php

namespace Smsfire;

use Smsfire\Traits\Utils;

class Client {

  use Utils;

  protected $authToken;

  function __construct($token) {
    $this->authToken = $this->parseAuthToken($token);
  }

}
