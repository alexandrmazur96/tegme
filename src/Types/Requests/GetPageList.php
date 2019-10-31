<?php

namespace Tegme\Types\Requests;

use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Types\Responses\PageList;

/**
 * Use this method to get a list of pages belonging to a Telegraph account.
 * @package Tegme\Types\Requests
 * @see PageList returns a PageList object, sorted by most recently created pages first.
 */
final class GetPageList extends BaseRequest
{
    /** @var string */
    private $accessToken;

    /** @var int|null */
    private $offset;

    /** @var int|null */
    private $limit;

    /**
     * @param string $accessToken   Access token of the Telegraph account.
     *
     * @param int|null $offset      Sequential number of the first page to be returned.
     *
     * @param int|null $limit       Limits the number of pages to be retrieved.
     *
     * @throws InvalidRequestInfoException look at exception to see what exactly wrong.
     *
     * @see PageList returns a PageList object, sorted by most recently created pages first.
     */
    public function __construct($accessToken, $offset = null, $limit = null)
    {
        $this->accessToken = $accessToken;
        $this->offset = $offset;
        $this->limit = $limit;
        $this->validate();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $requestPrototype = [
            'access_token' => $this->accessToken,
        ];

        if ($this->offset !== null) {
            $requestPrototype['offset'] = $this->offset;
        }

        if ($this->limit !== null) {
            $requestPrototype['limit'] = $this->limit;
        }

        return $requestPrototype;
    }

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
    public function hasPath()
    {
        return false;
    }

    /**
     * Return method name, which would be queried by this request.
     *
     * @return string
     * @link https://telegra.ph/api list of available methods you can find here.
     */
    public function getMethod()
    {
        return 'getPageList';
    }

    /**
     * Return path if exists.
     * @return string
     */
    public function getPath()
    {
        return '';
    }

    /**
     * Validate request information before making request.
     * @return void
     * @throws InvalidRequestInfoException
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    protected function validate()
    {
        if ($this->limit !== null && ($this->limit < 0 || $this->limit > 200)) {
            throw new InvalidRequestInfoException('limit parameter should be between 0 and 200');
        }

        if ($this->offset !== null && $this->offset < 0) {
            throw new InvalidRequestInfoException('offset parameter should be a positive number');
        }
    }
}
