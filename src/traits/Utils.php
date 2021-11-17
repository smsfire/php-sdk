<?php

namespace Smsfire\Traits;

use Smsfire\Configurations\Constants;
use Smsfire\Exceptions\SmsfireException;
use Smsfire\Exceptions\HttpException;

trait Utils
{

  /**
   * Parse auth token base64
   * @param string $token
   * @return string
   */
    private static function parseAuthToken($token): string
    {
        $decodedToken = base64_decode($token);
        $regexToken = preg_replace(Constants::REGEX_RULES['validBase64'], null, $decodedToken);

        if ($regexToken != $decodedToken || $regexToken == '') {
            throw new SmsfireException('Invalid base64 token string');
        }

        return $token;
    }

    private static function parseRequestData($data): array
    {
        $rawParams = $data[0] ?? [];
        $params = [
          'data' => $rawParams['data'] ?? null,
          'timeout' => $rawParams['timeout'] ?? null,
          'headers' => $rawParams['headers'] ?? null,
          'debug' => $rawParams['debug'] ?? false
        ];

        if (empty($params['data']) || empty($params['timeout']) || empty($params['headers'])) {
            throw new HttpException('Required params are empty');
        }

        return $params;
    }
}
