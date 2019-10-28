<?php

namespace Tegme\Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use Tegme\Telegraph;
use Tegme\Tests\TestCase;
use Tegme\Types\Requests\CreateAccount;

class TelegraphClientTest extends TestCase
{
    /** @var MockObject<Telegraph> */
    private $telegraphClient;

    public function testClientApiCall()
    {
        $this->telegraphClient->call(new CreateAccount(
            'test',
            'test_test',
            'https://t.me/test'
        ));
    }

    protected function setUp()
    {
        parent::setUp();
        $this->telegraphClient = $this->getMockBuilder(Telegraph::class)
            ->setMethods(['initCurlHandle', 'request'])
            ->getMock();

        $this->telegraphClient
            ->expects($this->atLeast(1))
            ->method('initCurlHandle');

        $this->telegraphClient
            ->expects($this->atLeast(1))
            ->method('request');
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->telegraphClient = null;
    }
}
