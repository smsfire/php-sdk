<?php

namespace Smsfire\Traits;

use Smsfire\Configurations\Constants;
use Smsfire\Exceptions\SanitizeExceptions;

date_default_timezone_set(Constants::DEFAULT_TIMEZONE);

trait Sanitization
{
    /**
     * Sanitize TO parameter of SMS message
     * @static
     * @throws SanitizeExceptions
     * @param string $data
     * @return string
     */
    private static function smsToParameter($data): string
    {
        $phone = preg_replace(Constants::REGEX_RULES['onlyNumeric'], null, $data);

        if (!is_numeric($phone)) {
            throw new SanitizeExceptions('Phone must be numeric');
        }

        if (empty($phone)) {
            throw new SanitizeExceptions('Parameter TO is required');
        }

        if (strlen($phone) > Constants::SMS_LENGTH['to']) {
            throw new SanitizeExceptions('Phone length must be less than 15 characters');
        }

        return trim($phone);
    }
    /**
     * Sanitize TEXT parameter of SMS message
     * @static
     * @throws SanitizeExceptions
     * @param string $data
     * @return string
     */
    private static function smsTextParameter($data): string
    {
        if (empty($data)) {
            throw new SanitizeExceptions('Parameter text is required');
        }

        if (!is_string($data)) {
            throw new SanitizeExceptions('text must be string');
        }

        if (strlen($data) > Constants::SMS_LENGTH['text']) {
            throw new SanitizeExceptions('text max length is '. Constants::SMS_LENGTH['text'] .' characters');
        }

        return trim($data);
    }
    /**
     * Sanitize FROM parameter of SMS message
     * Default value: SMSFIRE
     * @static
     * @throws SanitizeExceptions
     * @param string $data
     * @return string
     */
    private static function smsFromParameter($data): string
    {
        if (!empty($data) && !is_string($data)) {
            throw new SanitizeExceptions('from must be string');
        }

        if (strlen($data) > Constants::SMS_LENGTH['from']) {
            throw new SanitizeExceptions('from max length is '. Constants::SMS_LENGTH['from'] .' characters');
        }

        return ((empty($data)) ? Constants::DEFAULT_SMS_REMITENT : $data);
    }
    /**
     * Sanitize CUSTOMID parameter of SMS message
     * Default value: null
     * @static
     * @throws SanitizeExceptions
     * @param string|null $data
     * @return string|null
     */
    private static function smsCustomIdParameter($data): ?string
    {
        if (!empty($data) && !is_string($data)) {
            throw new SanitizeExceptions('customId must be string');
        }

        $customId = preg_replace(Constants::REGEX_RULES['customId'], null, $data);

        if (strlen($customId) > Constants::SMS_LENGTH['customId']) {
            throw new SanitizeExceptions('customId max length is '. Constants::SMS_LENGTH['customId'] .' characters');
        }

        return ((empty($customId)) ? null : $customId);
    }
    /**
     * Sanitize CAMPAIGNID parameter of SMS message
     * @static
     * @throws SanitizeExceptions
     * @param string|int $data
     * @return string|null
     */
    private static function smsCampaignIdParameter($data): ?string
    {
        $campaignId = preg_replace(Constants::REGEX_RULES['onlyNumeric'], null, $data);

        if (!empty($campaignId) && !is_numeric($campaignId)) {
            throw new SanitizeExceptions('campaignId must be numeric');
        }

        return ((empty($campaignId)) ? null : $campaignId);
    }

    /**
     * Sanitize FLASH parameter of SMS message
     * Default value: false
     * @static
     * @throws SanitizeExceptions
     * @param bool|null $data
     * @return bool
     */
    private static function smsFlashParameter($data): bool
    {
        if (empty($data)) {
            return false;
        }

        if (filter_var($data, FILTER_VALIDATE_BOOLEAN) === false) {
            throw new SanitizeExceptions('flash must be boolean');
        }

        return true;
    }

    /**
     * Sanitize ALLOWREPLY parameter of SMS message
     * Default value: false
     * @static
     * @throws SanitizeExceptions
     * @param bool $data
     * @return bool
     */
    private static function smsAllowReplyParameter($data): bool
    {
        if (empty($data)) {
            return false;
        }

        if (filter_var($data, FILTER_VALIDATE_BOOLEAN) === false) {
            throw new SanitizeExceptions('allowReply must be boolean');
        }

        return true;
    }

    /**
     * Sanitize SCHEDULETIME parameter of SMS message
     * Default value: null
     * @static
     * @throws SanitizeExceptions
     * @param string|null $data - Datetime ISO8601 - yyyy-mmm-dd hh:ii:ss
     * @return string|null
     */
    private static function dateTimeIso8601($data): ?string
    {
        if (empty($data)) {
            return null;
        }

        if (!empty($data) && !is_string($data)) {
            throw new SanitizeExceptions('scheduleTime must be date ISO8601 string');
        }

        return date(DATE_ISO8601, strtotime($data));
    }
    /**
     * Sanitize DESTINATIONS parameter of SMS Bulk message
     * @static
     * @throws SanitizeExceptions
     * @param array $data
     * @return array
     */
    private static function smsDestinationsParameter($data): array
    {
        $messagesVolume = count($data);
        $requiredParams = array_keys(Constants::SMS_MAP_PARAMETERS);
        $destinations = [];

        if ($messagesVolume < Constants::MINIMUM_BULK_REQUEST) {
            throw new SanitizeExceptions('At least ' . Constants::MINIMUM_BULK_REQUEST . ' destinations is needed on bulk request');
        }

        array_map(function ($item) use ($requiredParams, &$destinations) {
            if (array_key_exists($requiredParams[1], $item) === false) {
                throw new SanitizeExceptions('Parameter TO is required');
            }

            if (array_key_exists($requiredParams[2], $item) === false) {
                throw new SanitizeExceptions('Parameter TEXT is required');
            }

            $destinations[] = [
                $requiredParams[1] => self::smsToParameter($item[$requiredParams[1]]),
                $requiredParams[2] => self::smsTextParameter($item[$requiredParams[2]]),
                $requiredParams[3] => self::smsFromParameter(($item[$requiredParams[3]] ?? null)),
                $requiredParams[4] => self::smsCustomIdParameter(($item[$requiredParams[4]] ?? null)),
                $requiredParams[6] => self::smsFlashParameter(($item[$requiredParams[6]] ?? null))
            ];

            return $destinations;
        }, $data);

        return $destinations;
    }
    /**
     * Sanitize ids for sms messages ids
     * @static
     * @param string $ids - Ids with comma separation
     * @return array
     */
    private static function smsMessageIdsParameter($ids): array
    {
        $idsArray = explode(",", $ids);
        $idsFiltered = array_filter($idsArray, 'is_numeric');

        if (empty($idsFiltered)) {
            throw new SanitizeExceptions('Each Id need to be numeric data');
        }

        return $idsFiltered;
    }
    /**
     * Sanitize ids for sms messages cutomIds
     * @static
     * @param string $ids - customIds with comma separation
     * @return array
     */
    private static function smscustomIdsParameter($ids): array
    {
        $idsArray = explode(",", $ids);
        $idsFiltered = array_filter($idsArray, 'is_string');

        if (empty($idsFiltered)) {
            throw new SanitizeExceptions('Need at least one id to query');
        }

        return $idsFiltered;
    }
}
