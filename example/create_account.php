<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\CreateAccount;
use Tegme\Types\Response\Account;

/**
 * First of all - create telegraph client object.
 */

$telegraphClient = new Telegraph();

/*
 * Then we should create needed request object.
 * You can see what result would be returned after request in @see tag in
 * the request class constructor.
 */

$createAccountRequest = new CreateAccount(
    'Example Short Name',
    'Alexandr Mazur',
    'https://t.me/tegme'
);

try {
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
     * Access token: 85f83453eec82efeb3a9776c9e08fe8d99b3703e3aad65e42c007e0cc5c1
     * Author name: Alexandr Mazur
     * Author url: https://t.me/tegme
     * Auth url: https://edit.telegra.ph/auth/j1BznzBuW7TyGGVtLbWDAHgjT08kIP11RAye9aI3fz
     * Short name: Example Short Name
     * Page count:
     */
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
