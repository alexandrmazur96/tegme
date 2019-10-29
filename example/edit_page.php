<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Node;
use Tegme\Types\NodeElement;
use Tegme\Types\Requests\EditPage;
use Tegme\Types\Response\Page;
use Tegme\Types\TelegraphResponse;

/**
 * First of all - create telegraph client object.
 */
$telegraphClient = new Telegraph();

/**
 * Take access token from example/create_account.php
 */
$accessToken = '85f83453eec82efeb3a9776c9e08fe8d99b3703e3aad65e42c007e0cc5c1';

/**
 * Take page path from example/create_page.php
 */
$pagePath = 'Hello-world-10-29-9';

/**
 * We should build content for our new page.
 * Content contain nodes. Nodes is the representation of HTML tags.
 * @var Node[] $contentNodes
 */
$contentNodes = [
    new NodeElement('h1', null, ['Hello World!']),
    new NodeElement('br'),
    new NodeElement('h3', null, ['I create a page example!']),
    new NodeElement('p', null, [new NodeElement('i', null, ['Have a nice day, buddy!'])]),
];

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
        $contentNodes,
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
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}
