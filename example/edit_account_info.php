<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\EditAccountInfo;
use Tegme\Types\Response\Account;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

/**
 * Take access token from example/create_account.php
 */
$accessToken = '85f83453eec82efeb3a9776c9e08fe8d99b3703e3aad65e42c007e0cc5c1';

try {
    /**
     * Then we should create needed request object.
     * You can see what result would be returned after request in @see tag in
     * the request class constructor.
     */
    $editAccountInfoRequest = new EditAccountInfo(
        $accessToken,
        'Changed Short Name',
        'mr. Mazur'
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($editAccountInfoRequest);

    /**
     * We know what object would be returned after call() from request class constructor.
     * @var Account $accountObj
     */
    $accountObj = $response->getResult();

    echo 'Access token: ', $accountObj->getAccessToken(), PHP_EOL;
    echo 'Author name: ', $accountObj->getAuthorName(), PHP_EOL;
    echo 'Author url: ', $accountObj->getAuthorUrl(), PHP_EOL;
    echo 'Auth url: ', $accountObj->getAuthUrl(), PHP_EOL;
    echo 'Short name: ', $accountObj->getShortName(), PHP_EOL;
    echo 'Page count: ', $accountObj->getPageCount(), PHP_EOL;

    /**
     * Echos results:
     * Access token:
     * Author name: mr. Mazur
     * Author url: https://t.me/tegme
     * Auth url:
     * Short name: Changed Short Name
     * Page count:
     */
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}