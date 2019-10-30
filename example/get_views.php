<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\GetViews;
use Tegme\Types\Response\PageViews;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

/**
 * Path taken from edit_page.php example
 */
$pagePath = 'Hello-world-10-29-9';

try {
    /**
     * Then we should create needed request object.
     * You can see what result would be returned after request in @see tag in
     * the request class constructor.
     */
    $getViewsRequest = new GetViews(
        $pagePath,
        // optional (year, month, day and hour):
        2019,
        10,
        29,
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
    $response = $telegraphClient->call($getViewsRequest);

    /**
     * We know what object would be returned after call() from request class constructor.
     * @var PageViews $pageViewsObj
     */
    $pageViewsObj = $response->getResult();

    echo 'Page views count: ', $pageViewsObj->getViews(), PHP_EOL;

    /**
     * Echos results:
     *
     * Page views count: 2
     */
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
