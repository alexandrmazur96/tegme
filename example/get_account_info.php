<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\GetAccountInfo;
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
 * @link https://telegra.ph/api#getAccountInfo you can find method description here.
 */
$allPossibleAvailableFields = ['short_name', 'author_name', 'author_url', 'auth_url', 'page_count'];

try {
    /**
     * Then we should create needed request object.
     * You can see what result would be returned after request in @see tag in
     * the request class constructor.
     */
    $getAccountInfoRequest = new GetAccountInfo(
        $accessToken,
        $allPossibleAvailableFields
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($getAccountInfoRequest);

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
     * Auth url: https://edit.telegra.ph/auth/jjYqr9PXHb0H4avawu3iO0t8ztvaSEp9Ylzpvnlayj
     * Short name: Changed Short Name
     * Page count: 5
     */

    /**
     * Or in other case, you can use direct getAccountInfo() method:
     *
     * @var Account $accountObj
     */
    $accountObj = $telegraphClient->getAccountInfo($getAccountInfoRequest);

    // Result would be the same.
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
