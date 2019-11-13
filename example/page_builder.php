<?php

use Tegme\Builders\DomPageBuilder;
use Tegme\Exceptions\CurlException;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Exceptions\TelegraphApiException;
use Tegme\Telegraph;
use Tegme\Types\Dom\Tags\Aside;
use Tegme\Types\Dom\Tags\Br;
use Tegme\Types\Dom\Tags\H3;
use Tegme\Types\Dom\Tags\I;
use Tegme\Types\Dom\Tags\P;
use Tegme\Types\Requests\CreatePage;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * The main goal of page builder is to make easy access to page creating.
 *
 * The idea is to use node IDs so you can easily add new child nodes later.
 */

/**
 * First of all - create new builder instance.
 */
$builder = new DomPageBuilder();

/**
 * Then, start page building:
 *
 * Add poem title:
 */
$builder->addNewNodeWithValue(new H3(), 'Hymn');

/**
 * Add aside block for author name and poem creating date:
 */
$builder->addNewNode(new Aside(), 'author_block');

/**
 * Add author name and poem creating date node elements (without text in) to aside block.
 */
$builder->addChildrenNodeElement('author_block', new P(), 'name');
$builder->addChildrenNodeElement('author_block', new P(), 'date');

/**
 * Add text to author name and poem creating date nodes.
 */
$builder->addChildrenNodeText('name', 'Ivan Franko');
$builder->addChildrenNodeText('date', '1880 year');

/**
 * Next step - add poem content:
 */
$builder->addNewNodeWithValue(new P(), 'The Eternal Revolutionary - ');
$builder->addNewNodeWithValue(new P(), 'The spirit that thirsts for battle,');
$builder->addNewNodeWithValue(new P(), 'He cries for progress, happiness and will,');
$builder->addNewNodeWithValue(new P(), 'He lives, he has not yet died.');
$builder->addNewNodeWithValue(new P(), 'No priest torture,');
$builder->addNewNodeWithValue(new P(), 'Not royal prison walls,');
$builder->addNewNodeWithValue(new P(), 'All military forces,');
$builder->addNewNodeWithValue(new P(), 'No guns are polished,');
$builder->addNewNodeWithValue(new P(), 'Not spy craft');
$builder->addNewNodeWithValue(new P(), 'He has not been taken to the mound yet.');

/**
 * Of course its not a whole poem:
 */
$builder->addNewNode(new Br());
$builder->addNewNodeWithValue(new I(), 'to be continued...');

/**
 * Build our new page:
 */
$page = $builder->build();

/**
 * Create telegraph client object for post it.
 */
$telegraphClient = new Telegraph();

try {
    /**
     * Create request object for creating new page.
     */
    $createPageRequest = new CreatePage(
        'eff0c0b69bf2317cc6f75c59e3dd5c9a49c64bff3cb130ee8ebfdd7b9195',
        'Ivan Franko - Hymn',
        // use our fresh page:
        $page,
        'Alexandr Mazur',
        'https://t.me/tegme',
        true
    );
} catch (InvalidRequestInfoException $e) {
    echo 'You try to create request with some invalid parameters. Details: ', $e->getMessage(), PHP_EOL;
}

try {
    /**
     * Request telegra.ph API for creating page:
     */
    $pageObj = $telegraphClient->createPage($createPageRequest);
} catch (CurlException $e) {
    echo 'Curl error has occurred. Details: ', $e->getMessage(), PHP_EOL;
} catch (TelegraphApiException $e) {
    echo 'Telegraph API failed. Details: ', $e->getMessage(), PHP_EOL;
}

/**
 * Here we are, look at $pageObj->getUrl() for your new telegraph page.
 */
echo 'Author name: ', $pageObj->getAuthorName(), PHP_EOL;
echo 'Author url: ', $pageObj->getAuthorUrl(), PHP_EOL;
echo 'Title: ', $pageObj->getTitle(), PHP_EOL;
echo 'Url: ', $pageObj->getUrl(), PHP_EOL;
echo 'Views: ', $pageObj->getViews(), PHP_EOL;
echo 'Can edit? ', $pageObj->getCanEdit() ? 'yes' : 'no', PHP_EOL;
echo 'Content: ', json_encode($pageObj->getContent()), PHP_EOL;
