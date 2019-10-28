<?php

namespace Tegme\Types\Requests;

use JsonSerializable;
use Tegme\Exceptions\InvalidRequestInfoException;

/**
 * Base class for all requests to telegra.ph API.
 * @package Tegme\Types\Requests
 */
abstract class BaseRequest implements JsonSerializable
{
    /**
     * Indicate that request should be compatible with method/path form.
     *
     * telegra.ph have two syntax for querying API:
     * https://api.telegra.ph/%method% and https://api.telegra.ph/%method%/%path%
     *
     * So depends on this flag we know to which one form we should request.
     *
     * @return bool
     */
    abstract public function hasPath();

    /**
     * Return method name, which would be queried by this request.
     *
     * @return string
     * @link https://telegra.ph/api list of available methods you can find here.
     */
    abstract public function getMethod();

    /**
     * Validate request information before making request.
     * @return void
     * @throws InvalidRequestInfoException
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    abstract protected function validate();
}
