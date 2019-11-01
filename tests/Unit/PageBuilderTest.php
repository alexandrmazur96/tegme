<?php

namespace Tegme\Tests\Unit;

use Tegme\PageBuilder;
use Tegme\Tests\TestCase;
use Tegme\Types\Tags\H3;
use Tegme\Types\Tags\P;

class PageBuilderTest extends TestCase
{

    public function testCreatePage()
    {
        $pageBuilder = new PageBuilder();
        $pageBuilder->newTag(new H3());
        $pageBuilder->insertChildrenTag(null, 'Hello world');
        $pageBuilder->newTag(new P());
        $pageBuilder->insertChildrenTag(null, 'Have a nice, buddy!');

        $page = $pageBuilder->build();
        echo json_encode($page, JSON_PRETTY_PRINT);
    }
}
