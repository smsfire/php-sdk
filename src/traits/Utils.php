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
    private static function parseAuthToken(string $token): string
    {
        $decodedToken = base64_decode($token);
        $regexToken = preg_replace(Constants::REGEX_RULES['validBase64'], null, $decodedToken);

        if ($regexToken != $decodedToken || $regexToken == '') {
            throw new SmsfireException('Invalid base64 token string');
        }

        return $token;
    }
    /**
     * Parse request data
     * @param array $data
     * @return array
     */
    private static function parseRequestData(array $data): array
    {
        $rawParams = $data[0] ?? [];

        if (empty($rawParams)) {
            throw new HttpException('Required params are empty');
        }

        $params = [
            'payload' => $rawParams['payload'] ?? [],
            'timeout' => $rawParams['timeout'] ?? null,
            'headers' => $rawParams['headers'] ?? null,
            'debug'   => $rawParams['debug'] ?? false
        ];

        if (empty($params['headers'])) {
            throw new HttpException('Required headers are empty');
        }

        return $params;
    }

    /**
     * Get the API parameters
     * @return array
     */
    private static function getSmsApiParametersMap(): array
    {
        return array_keys(Constants::SMS_MAP_PARAMETERS);
    }
}
