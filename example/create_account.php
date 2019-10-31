<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\CreateAccount;
use Tegme\Types\Responses\Account;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

try {
    /**
     * Then we should create needed request object.
     * You can see what result would be returned after request in @see tag in
     * the request class constructor.
     */
    $createAccountRequest = new CreateAccount(
        'Example Short Name',
        'Alexandr Mazur',
        'https://t.me/tegme'
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($createAccountRequest);

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
     * Access token: d6dad593bdeb132be0ee7c9fbe5bdc6c59e052dffaecfe405a13028af84c
     * Author name: Alexandr Mazur
     * Author url: https://t.me/tegme
     * Auth url: https://edit.telegra.ph/auth/j1BznzBuW7TyGGVtLbWDAHgjT08kIP11RAye9aI3fz
     * Short name: Example Short Name
     * Page count:
     */

    /**
     * Or in other case, you can use direct createAccount() method:
     *
     * @var Account $accountObj
     */
    $accountObj = $telegraphClient->createAccount($createAccountRequest);

    // Result would be the same.
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
