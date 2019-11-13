<?php

namespace Tegme\Tests\Unit;

use Exception;
use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Tests\TestCase;
use Tegme\Types\Dom\Attribute;
use Tegme\Types\Dom\DomPage;
use Tegme\Types\Dom\Nodes\NodeElement;
use Tegme\Types\Dom\Nodes\NodeText;
use Tegme\Types\Dom\Tags\A;
use Tegme\Types\Dom\Tags\Aside;
use Tegme\Types\Requests\CreateAccount;
use Tegme\Types\Requests\CreatePage;
use Tegme\Types\Requests\EditAccountInfo;
use Tegme\Types\Requests\EditPage;
use Tegme\Types\Requests\GetAccountInfo;
use Tegme\Types\Requests\GetPage;
use Tegme\Types\Requests\GetPageList;
use Tegme\Types\Requests\GetViews;
use Tegme\Types\Requests\RevokeAccessToken;

class TelegraphRequestsTest extends TestCase
{
    public function testCreateAccountSuccess()
    {
        $shortName = 'test_short_name';
        $authorName = 'test_author_name';
        $authorUrl = 'test_author_url';
        try {
            $request = new CreateAccount(
                $shortName,
                $authorName,
                $authorUrl
            );

            $this->assertEquals('createAccount', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'short_name' => $shortName,
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                ],
                $request->toArray()
            );

            $request = new CreateAccount(
                $shortName,
                $authorName
            );

            $this->assertEquals('createAccount', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'short_name' => $shortName,
                    'author_name' => $authorName,
                ],
                $request->toArray()
            );

            $request = new CreateAccount(
                $shortName
            );

            $this->assertEquals('createAccount', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'short_name' => $shortName,
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testCreateAccountFailure()
    {
        try {
            new CreateAccount('');
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreateAccount(str_repeat('T', 33));
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreateAccount('Valid Name', str_repeat('T', 129));
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreateAccount(
                'Valid Name',
                'Valid Author Name',
                str_repeat('T', 513)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testCreatePageSuccess()
    {
        $accessToken = 'test_access_token';
        $title = 'test_title';
        $nodeList = [
            new NodeElement(new A(['href' => 'https://example.com']), new NodeText('test_link')),
            new NodeElement(new A([new Attribute('href', 'https://example.com')]), new NodeText('another_test_link'))
        ];
        $content = new DomPage($nodeList);
        $authorName = 'test_author_name';
        $authorUrl = 'test_author_url';
        $returnContent = true;

        try {
            $request = new CreatePage(
                $accessToken,
                $title,
                $content,
                $authorName,
                $authorUrl,
                $returnContent
            );

            $this->assertEquals('createPage', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                    'return_content' => true,
                ],
                $request->toArray()
            );

            $request = new CreatePage(
                $accessToken,
                $title,
                $content,
                $authorName,
                $authorUrl
            );

            $this->assertEquals('createPage', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                ],
                $request->toArray()
            );

            $request = new CreatePage(
                $accessToken,
                $title,
                $content,
                $authorName
            );

            $this->assertEquals('createPage', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                ],
                $request->toArray()
            );

            $request = new CreatePage(
                $accessToken,
                $title,
                $content
            );

            $this->assertEquals('createPage', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testCreatePageFailure()
    {
        $accessToken = 'test_access_token';
        $title = 'test_title';
        $content = new DomPage([new NodeElement(new A(['href' => 'https://example.com']), new NodeText('test_link'))]);
        $authorName = 'test_author_name';

        try {
            new CreatePage(
                $accessToken,
                $title . str_repeat('A', 256),
                $content
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreatePage(
                $accessToken,
                '',
                $content
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        $failedContent = [];
        for ($i = 0; $i < 3000; $i++) {
            $failedContent[] = new NodeElement(new Aside(), new NodeText('TEST_TEST_TEST'));
        }
        try {
            new CreatePage(
                $accessToken,
                $title,
                new DomPage($failedContent)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreatePage(
                $accessToken,
                $title,
                $content,
                str_repeat('A', 129)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new CreatePage(
                $accessToken,
                $title,
                $content,
                $authorName,
                str_repeat('A', 513)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testEditAccountInfoSuccess()
    {
        $accessToken = 'test_access_token';
        $shortName = 'test_short_name';
        $authorName = 'test_author_name';
        $authorUrl = 'test_author_url';

        try {
            $request = new EditAccountInfo(
                $accessToken,
                $shortName,
                $authorName,
                $authorUrl
            );
            $this->assertEquals('editAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'short_name' => $shortName,
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                ],
                $request->toArray()
            );

            $request = new EditAccountInfo(
                $accessToken,
                $shortName,
                $authorName
            );
            $this->assertEquals('editAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'short_name' => $shortName,
                    'author_name' => $authorName,
                ],
                $request->toArray()
            );

            $request = new EditAccountInfo(
                $accessToken,
                $shortName
            );
            $this->assertEquals('editAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'short_name' => $shortName,
                ],
                $request->toArray()
            );

            $request = new EditAccountInfo(
                $accessToken,
                $shortName
            );
            $this->assertEquals('editAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'short_name' => $shortName,
                ],
                $request->toArray()
            );

            $request = new EditAccountInfo(
                $accessToken
            );
            $this->assertEquals('editAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testEditAccountInfoFailure()
    {
        $accessToken = 'test_access_token';
        $shortName = 'test_short_name';
        $authorName = 'test_author_name';

        try {
            new EditAccountInfo(
                $accessToken,
                $shortName,
                $authorName,
                str_repeat('A', 513)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditAccountInfo(
                $accessToken,
                $shortName,
                str_repeat('A', 129)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditAccountInfo(
                $accessToken,
                ''
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditAccountInfo(
                $accessToken,
                str_repeat('A', 33)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testEditPageSuccess()
    {
        $accessToken = 'test_access_token';
        $path = 'test_path';
        $title = 'test_title';
        $content = new DomPage([new NodeElement(new A(['href' => 'https://example.com',]), new NodeText('test_link'))]);
        $authorName = 'test_author_name';
        $authorUrl = 'test_author_url';
        $returnContent = true;
        try {
            $request = new EditPage(
                $accessToken,
                $path,
                $title,
                $content,
                $authorName,
                $authorUrl,
                $returnContent
            );

            $this->assertEquals('editPage', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals('test_path', $request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                    'return_content' => $returnContent,
                ],
                $request->toArray()
            );

            $request = new EditPage(
                $accessToken,
                $path,
                $title,
                $content,
                $authorName,
                $authorUrl
            );

            $this->assertEquals('editPage', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals('test_path', $request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                    'author_url' => $authorUrl,
                ],
                $request->toArray()
            );

            $request = new EditPage(
                $accessToken,
                $path,
                $title,
                $content,
                $authorName
            );

            $this->assertEquals('editPage', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals('test_path', $request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                    'author_name' => $authorName,
                ],
                $request->toArray()
            );

            $request = new EditPage(
                $accessToken,
                $path,
                $title,
                $content
            );

            $this->assertEquals('editPage', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals('test_path', $request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'title' => $title,
                    'content' => json_encode($content),
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testEditPageFailure()
    {
        $accessToken = 'test_access_token';
        $path = 'test_path';
        $title = 'test_title';
        $content = new DomPage([new NodeElement(new A(['href' => 'https://example.com',]), new NodeText('test_link'))]);
        $authorName = 'test_author_name';

        try {
            new EditPage(
                $accessToken,
                $path,
                $title,
                $content,
                $authorName,
                str_repeat('A', 513)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditPage(
                $accessToken,
                $path,
                $title,
                $content,
                str_repeat('A', 129)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditPage(
                $accessToken,
                $path,
                '',
                $content
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new EditPage(
                $accessToken,
                $path,
                str_repeat('A', 257),
                $content
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        $failedContent = [];
        for ($i = 0; $i < 3000; $i++) {
            $failedContent[] = new NodeElement(new Aside(), new NodeText('TEST_TEST_TEST'));
        }
        try {
            new EditPage(
                $accessToken,
                $path,
                $title,
                new DomPage($failedContent)
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testGetAccountInfoSuccess()
    {
        $accessToken = 'test_access_token';
        $fields = ['short_name', 'author_name',];
        try {
            $request = new GetAccountInfo(
                $accessToken,
                $fields
            );

            $this->assertEquals('getAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'fields' => json_encode($fields),
                ],
                $request->toArray()
            );

            $request = new GetAccountInfo(
                $accessToken
            );

            $this->assertEquals('getAccountInfo', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testGetAccountInfoFailure()
    {
        $accessToken = 'test_access_token';
        try {
            new GetAccountInfo(
                $accessToken,
                []
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testGetPageSuccess()
    {
        $path = 'test_path';
        $returnContent = true;

        $request = new GetPage(
            $path,
            $returnContent
        );

        $this->assertEquals('getPage', $request->getMethod());
        $this->assertTrue($request->hasPath());
        $this->assertEquals($path, $request->getPath());
        $this->assertEquals(
            [
                'return_content' => true,
            ],
            $request->toArray()
        );

        $request = new GetPage(
            $path
        );

        $this->assertEquals('getPage', $request->getMethod());
        $this->assertTrue($request->hasPath());
        $this->assertEquals($path, $request->getPath());
        $this->assertEquals([], $request->toArray());
    }

    public function testGetPageListSuccess()
    {
        $accessToken = 'test_access_token';
        $offset = 10;
        $limit = 50;

        try {
            $request = new GetPageList(
                $accessToken,
                $offset,
                $limit
            );

            $this->assertEquals('getPageList', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'offset' => $offset,
                    'limit' => $limit,
                ],
                $request->toArray()
            );

            $request = new GetPageList(
                $accessToken,
                $offset
            );

            $this->assertEquals('getPageList', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                    'offset' => $offset,
                ],
                $request->toArray()
            );

            $request = new GetPageList(
                $accessToken
            );

            $this->assertEquals('getPageList', $request->getMethod());
            $this->assertFalse($request->hasPath());
            $this->assertEmpty($request->getPath());
            $this->assertEquals(
                [
                    'access_token' => $accessToken,
                ],
                $request->toArray()
            );
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testGetPageListFailure()
    {
        $accessToken = 'test_access_token';
        $offset = 10;

        try {
            new GetPageList(
                $accessToken,
                $offset,
                -1
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetPageList(
                $accessToken,
                $offset,
                300
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetPageList(
                $accessToken,
                -1
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testGetViewsSuccess()
    {
        $path = 'test_path';
        $year = 2020;
        $month = 1;
        $day = 10;
        $hour = 12;

        try {
            $request = new GetViews(
                $path,
                $year,
                $month,
                $day,
                $hour
            );

            $this->assertEquals('getViews', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals($path, $request->getPath());
            $this->assertEquals(
                [
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                    'hour' => $hour,
                ],
                $request->toArray()
            );

            $request = new GetViews(
                $path,
                $year,
                $month,
                $day
            );

            $this->assertEquals('getViews', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals($path, $request->getPath());
            $this->assertEquals(
                [
                    'year' => $year,
                    'month' => $month,
                    'day' => $day,
                ],
                $request->toArray()
            );

            $request = new GetViews(
                $path,
                $year,
                $month
            );

            $this->assertEquals('getViews', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals($path, $request->getPath());
            $this->assertEquals(
                [
                    'year' => $year,
                    'month' => $month,
                ],
                $request->toArray()
            );

            $request = new GetViews(
                $path,
                $year
            );

            $this->assertEquals('getViews', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals($path, $request->getPath());
            $this->assertEquals(
                [
                    'year' => $year,
                ],
                $request->toArray()
            );

            $request = new GetViews(
                $path
            );

            $this->assertEquals('getViews', $request->getMethod());
            $this->assertTrue($request->hasPath());
            $this->assertEquals($path, $request->getPath());
            $this->assertEquals([], $request->toArray());
        } catch (Exception $e) {
            $this->fail('Exception has occurred! ' . $e->getMessage());
        }
    }

    public function testGetViewsFailure()
    {
        $path = 'test_path';
        $year = 2000;
        $month = 12;
        $day = 31;
        $hour = 0;

        try {
            new GetViews(
                $path,
                1999
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                2101
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                0
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                13
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                $month,
                0
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                $month,
                32
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                $month,
                $day,
                -1
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                $month,
                $day,
                25
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                null,
                null,
                $day,
                $hour
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                null,
                null,
                null,
                $hour
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                null,
                $month,
                $day,
                $hour
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                null,
                $day,
                $hour
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }

        try {
            new GetViews(
                $path,
                $year,
                $month,
                null,
                $hour
            );
            $this->fail('Expected exception, but no occurred!');
        } catch (Exception $e) {
            $this->assertEquals(InvalidRequestInfoException::class, get_class($e));
        }
    }

    public function testRevokeAccessTokenSuccess()
    {
        $accessToken = 'test_access_token';

        $request = new RevokeAccessToken(
            $accessToken
        );

        $this->assertEquals('revokeAccessToken', $request->getMethod());
        $this->assertFalse($request->hasPath());
        $this->assertEmpty($request->getPath());
        $this->assertEquals(
            [
                'access_token' => $accessToken,
            ],
            $request->toArray()
        );
    }
}
