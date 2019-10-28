<?php

namespace Tegme\Types;

use Tegme\Factories\AbstractTelegraphResponseFactory;

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
        $this->apiResponse = $apiResponse;
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->factory->build($this->apiResponse, $this->method);
    }
}
