<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\RevokeAccessToken;
use Tegme\Types\Response\Account;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

/**
 * Take access token from example/create_account.php
 */
$accessToken = 'd6dad593bdeb132be0ee7c9fbe5bdc6c59e052dffaecfe405a13028af84c';

/**
 * Then we should create needed request object.
 * You can see what result would be returned after request in @see tag in
 * the request class constructor.
 */
$revokeAccessTokenRequest = new RevokeAccessToken(
    $accessToken
);

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($revokeAccessTokenRequest);

    /**
     * We know what object would be returned after call() from request class constructor.
     * @var Account $accountObj
     */
    $accountObj = $response->getResult();

    /**
     * Note, that when we call /revokeAccessToken method - only new Access Token and Auth url presented.
     */

    echo 'Access token: ', $accountObj->getAccessToken(), PHP_EOL;
    echo 'Author name: ', $accountObj->getAuthorName(), PHP_EOL;
    echo 'Author url: ', $accountObj->getAuthorUrl(), PHP_EOL;
    echo 'Auth url: ', $accountObj->getAuthUrl(), PHP_EOL;
    echo 'Short name: ', $accountObj->getShortName(), PHP_EOL;
    echo 'Page count: ', $accountObj->getPageCount(), PHP_EOL;

    /**
     * Echos results:
     * Access token: b092f9e5dba3567b86c3badad93d94402f861af38cea74caf2195058acd5
     * Author name:
     * Author url:
     * Auth url: https://edit.telegra.ph/auth/oKwNbsMznle1tLVCEcCV0zTLS4k2SUkeER0NjMnE7z
     * Short name:
     * Page count:
     */
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
