<?php

namespace Tegme;

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Factories\TelegraphResponseFactory;
use Tegme\Types\Requests\BaseRequest;
use Tegme\Types\TelegraphResponse;
use Tegme\Utils\Curl;

/**
 * @package Tegme
 */
class Telegraph
{
    const TELEGRAPH_API = 'https://api.telegra.ph';

    /**
     * Call given telegra.ph request.
     * @param BaseRequest $request
     * @return TelegraphResponse
     * @throws CurlException
     * @throws TelegraphApiException
     */
    public function call(BaseRequest $request)
    {
        $curlHandle = $this->initCurlHandle($request);

        if ($curlHandle === false) {
            throw new CurlException('Unable to initiate curl handle');
        }

        return $this->request($curlHandle, $request->getMethod());
    }

    /**
     * Create and initiate curl handle resource.
     * @param BaseRequest $request
     * @return false|resource
     */
    protected function initCurlHandle(BaseRequest $request)
    {
        $curlHandle = curl_init();
        $url = self::TELEGRAPH_API . '/' . $request->getMethod();

        if ($request->hasPath()) {
            $url .= '/' . $request->getPath();
        }

        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($request->toArray()));
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        return $curlHandle;
    }

    /**
     * Make request to telegra.ph API.
     * @param resource $curlHandle
     * @param string $method
     * @return TelegraphResponse
     * @throws CurlException
     * @throws TelegraphApiException
     */
    protected function request($curlHandle, $method)
    {
        $rawCurlResponse = Curl::execute($curlHandle);

        $curlResponse = json_decode($rawCurlResponse, true);

        if ($curlResponse === null) {
            throw new TelegraphApiException('Unexpected telegraph response format. Raw response: ' . $rawCurlResponse);
        }

        if ($curlResponse['ok'] === false) {
            throw new TelegraphApiException('Telegraph API exception. Error: ' . $curlResponse['error']);
        }

        return new TelegraphResponse(new TelegraphResponseFactory(), $curlResponse['result'], $method);
    }
}
