<?php

namespace Tegme\Utils;

use Tegme\Exceptions\CurlException;

final class Curl
{
    private static $retriableErrorCodes = [
        CURLE_COULDNT_RESOLVE_HOST,
        CURLE_COULDNT_CONNECT,
        CURLE_HTTP_NOT_FOUND,
        CURLE_READ_ERROR,
        CURLE_OPERATION_TIMEOUTED,
        CURLE_HTTP_POST_ERROR,
        CURLE_SSL_CONNECT_ERROR,
    ];


    /**
     * Executes a CURL request with optional retries and exception on failure
     *
     * @param resource $curlHandler
     * @param int $retriesCount
     * @param bool $closeAfterDone
     * @return bool|string
     * @throws CurlException
     * @see curl_exec for possible return types.
     */
    public static function execute($curlHandler, $retriesCount = 5, $closeAfterDone = true)
    {
        while ($retriesCount--) {
            $curlResponse = curl_exec($curlHandler);

            if ($curlResponse === false) {
                $curlErrno = curl_errno($curlHandler);

                if ($retriesCount !== 0 || !in_array($curlErrno, self::$retriableErrorCodes, true)) {
                    $curlError = curl_error($curlHandler);
                    if ($closeAfterDone) {
                        curl_close($curlHandler);
                    }
                    throw new CurlException(sprintf('Curl error. Error Code [%d]: [%s].', $curlErrno, $curlError));
                }
                continue;
            }

            if ($closeAfterDone) {
                curl_close($curlHandler);
            }

            return $curlResponse;
        }

        return false;
    }
}
