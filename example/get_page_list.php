<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\GetPageList;
use Tegme\Types\Response\PageList;
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
    $getPageListRequest = new GetPageList(
        $accessToken,
        // Optional parameters (offset and limit):
        null,
        null
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($getPageListRequest);

    /**
     * We know what object would be returned after call() from request class constructor.
     * @var PageList $pageListObj
     */
    $pageListObj = $response->getResult();

    echo 'Total page count: ', $pageListObj->getTotalCount(), PHP_EOL;
    echo 'Pages: ', json_encode($pageListObj->getPages(), JSON_PRETTY_PRINT), PHP_EOL;

    /**
     * Echos return:
     *
     * Total page count: 5
     * Pages:
     *  [
     *       {
     *           "path": "Hello-world-10-29-9",
     *           "url": "https:\/\/telegra.ph\/Hello-world-10-29-9",
     *           "title": "Hello World (Changed)!",
     *            "description": "I create a page example!\nHave a nice day, buddy!",
     *           "views": 3,
     *           "can_edit": true
     *       },
     *       {
     *           "path": "Hello-world-10-29-8",
     *           "url": "https:\/\/telegra.ph\/Hello-world-10-29-8",
     *           "title": "Hello, world!",
     *           "description": "I create page example!\nHave a nice day, buddy!",
     *           "views": 1,
     *           "author_name": "Alexandr Mazur",
     *           "author_url": "https:\/\/t.me\/tegme",
     *           "can_edit": true
     *       },
     *       {
     *           "path": "Hello-world-10-29-7",
     *           "url": "https:\/\/telegra.ph\/Hello-world-10-29-7",
     *           "title": "Hello, world!",
     *           "description": "I am create page example!\nHave a nice day, buddy!",
     *           "views": 2,
     *           "author_name": "Alexandr Mazur",
     *           "author_url": "https:\/\/t.me\/tegme",
     *           "can_edit": true
     *       },
     *       {
     *           "path": "Hello-world-10-29-6",
     *           "url": "https:\/\/telegra.ph\/Hello-world-10-29-6",
     *           "title": "Hello, world!",
     *           "description": "I am create page example!\nHave a nice day, buddy!",
     *           "views": 1,
     *           "author_name": "Alexandr Mazur",
     *           "author_url": "https:\/\/t.me\/tegme",
     *           "can_edit": true
     *       },
     *       {
     *          "path": "Hello-world-10-29-5",
     *          "url": "https:\/\/telegra.ph\/Hello-world-10-29-5",
     *          "title": "Hello, world!",
     *          "description": "I am create page example!\nHave a nice day, buddy!",
     *           "views": 1,
     *          "author_name": "Alexandr Mazur",
     *          "author_url": "https:\/\/t.me\/tegme",
     *          "can_edit": true
     *      }
     *  ]
     */
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
