<?php

namespace Smsfire\Traits;

use Smsfire\Exceptions\SmsfireException;
use Smsfire\Configurations\Constants;

trait Utils {

  /**
   * Parse auth token base64
   * @param string $token
   */
  private static function parseAuthToken($token) {

    $decodedToken = base64_decode($token);
    $regexToken = preg_replace(Constants::REGEX_RULES['validBase64'], null, $decodedToken);

    if ($regexToken != $decodedToken || $regexToken == '') {
      throw new SmsfireException('Invalid base64 token string');
    }

    return $token;

  }

}
