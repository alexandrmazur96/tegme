<?php

namespace Tegme\Factories;

abstract class AbstractTelegraphResponseFactory
{
    /**
     * @param array $apiResponse
     * @param string $method
     * @return mixed
     */
    abstract public function build(array $apiResponse, $method);
}
