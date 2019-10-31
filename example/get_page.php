<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Requests\GetPage;
use Tegme\Types\Response\Page;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

/**
 * Path taken from edit_page.php example
 */
$pagePath = 'Hello-world-10-29-9';

/**
 * Then we should create needed request object.
 * You can see what result would be returned after request in @see tag in
 * the request class constructor.
 */
$getPageRequest = new GetPage(
    $pagePath,
    true
);

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($getPageRequest);

    /**
     * We know what object would be returned after call() from request class constructor.
     * @var Page $pageObj
     */
    $pageObj = $response->getResult();

    echo 'Author name: ', $pageObj->getAuthorName(), PHP_EOL;
    echo 'Author url: ', $pageObj->getAuthorUrl(), PHP_EOL;
    echo 'Title: ', $pageObj->getTitle(), PHP_EOL;
    echo 'Url: ', $pageObj->getUrl(), PHP_EOL;
    echo 'Views: ', $pageObj->getViews(), PHP_EOL;
    echo 'Can edit? ', $pageObj->getCanEdit() ? 'yes' : 'no', PHP_EOL;
    echo 'Content: ', json_encode($pageObj->getContent(), JSON_PRETTY_PRINT), PHP_EOL;

    /**
     * Echos result:
     *
     * Author name:
     * Author url:
     * Title: Hello World (Changed)!
     * Url: https://telegra.ph/Hello-world-10-29-9
     * Views: 3
     * Can edit? no
     * Content:
     *   [
     *     "Hello World!",
     *     {
     *         "tag": "br"
     *     },
     *     {
     *         "tag": "h3",
     *       "attrs": {
     *         "id": "I-create-a-page-example&#33;"
     *       },
     *       "children": [
     *         "I create a page example!"
     *     ]
     *     },
     *     {
     *         "tag": "p",
     *       "children": [
     *         {
     *             "tag": "em",
     *           "children": [
     *             "Have a nice day, buddy!"
     *         ]
     *         }
     *       ]
     *    }
     *   ]
     */

    /**
     * Or in other case, you can use direct getPage() method:
     *
     * @var Page $pageObj
     */
    $pageObj = $telegraphClient->getPage($getPageRequest);

    // Result would be the same.
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
