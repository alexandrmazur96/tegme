<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Dom\DomPage;
use Tegme\Types\Dom\Nodes\NodeElement;
use Tegme\Types\Dom\Nodes\NodeInterface;
use Tegme\Types\Dom\Nodes\NodeText;
use Tegme\Types\Dom\Tags\Br;
use Tegme\Types\Dom\Tags\H3;
use Tegme\Types\Dom\Tags\I;
use Tegme\Types\Dom\Tags\P;
use Tegme\Types\Requests\EditPage;
use Tegme\Types\Responses\Page;
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
 * Take page path from example/create_page.php
 */
$pagePath = 'Hello-world-10-29-9';

/**
 * We should build content for our new page.
 * Content contain nodes. Nodes is the representation of HTML tags.
 * @var NodeInterface[] $contentNodes
 */
$contentNodes = [
    new NodeElement(new H3(), new NodeText('Hello World!')),
    new NodeElement(new Br()),
    new NodeElement(new H3(), new NodeText('I create a page example!')),
    new NodeElement(new P(), [new NodeElement(new I(), new NodeText('Have a nice day, buddy!'))]),
];

$page = new DomPage($contentNodes);

try {
    /**
     * Then we should create needed request object.
     * You can see what result would be returned after request in @see tag in
     * the request class constructor.
     */
    $editPageRequest = new EditPage(
        $accessToken,
        $pagePath,
        'Hello World (Changed)!',
        $page,
        // Optional parameters:
        null,
        null,
        true
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Make request to telegra.ph API.
     * @var TelegraphResponse $response
     */
    $response = $telegraphClient->call($editPageRequest);

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
    echo 'Content: ', json_encode($pageObj->getContent()), PHP_EOL;

    /**
     * You can find page example here @link https://telegra.ph/Hello-world-10-29-9
     */

    /**
     * Or in other case, you can use direct editPage() method:
     *
     * @var Page $pageObj
     */
    $pageObj = $telegraphClient->editPage($editPageRequest);

    // Result would be the same.
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
