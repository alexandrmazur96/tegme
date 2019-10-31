<?php

namespace Tegme\Types;

use Tegme\Factories\AbstractTelegraphResponseFactory;
use Tegme\Types\Responses\Account;
use Tegme\Types\Responses\Page;
use Tegme\Types\Responses\PageList;
use Tegme\Types\Responses\PageViews;

/**
 * Represent request response from telegra.ph API.
 * @package Tegme\Types
 */
class TelegraphResponse
{
    /** @var AbstractTelegraphResponseFactory */
    private $factory;

    /** @var array */
    private $apiResponse;

    /** @var array */
    private $rawResponse;

    /** @var string */
    private $method;

    /**
     * @param AbstractTelegraphResponseFactory $factory
     * @param array $apiResponse
     * @param string $method
     */
    public function __construct(AbstractTelegraphResponseFactory $factory, array $apiResponse, $method)
    {
        $this->factory = $factory;
        $this->apiResponse = $apiResponse['result'];
        $this->rawResponse = $apiResponse;
        $this->method = $method;
    }

    /**
     * Return raw response from API.
     * Contains "ok" status and "result" field with data.
     *
     * @return array
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

    /**
     * Return one of Response object, depends on called method.
     *<br><br>
     * Possible object that may returned from this method you can find below:
     *
     * @see Account
     * @see Page
     * @see PageList
     * @see PageViews
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->factory->build($this->apiResponse, $this->method);
    }
}
