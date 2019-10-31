<?php

namespace Tegme\Types\Requests;

use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Types\Responses\Account;

/**
 * Use this method to get information about a Telegraph account.
 * @package Tegme\Types\Requests
 * @see Account returns an Account object on success.
 */
final class GetAccountInfo extends BaseRequest
{
    /** @var string */
    private $accessToken;

    /** @var string[]|null */
    private $fields;

    /**
     * @param string $accessToken       Access token of the Telegraph account.
     *
     * @param string[]|null $fields     List of account fields to return.
     *                                  <i>Available fields:</i>
     *                                  <pre>[short_name, author_name, author_url, auth_url, page_count]</pre>
     *
     * @throws InvalidRequestInfoException look at exception to see what exactly wrong.
     *
     * @see Account returns an Account object on success.
     */
    public function __construct($accessToken, array $fields = null)
    {
        $this->accessToken = $accessToken;
        $this->fields = $fields;
        $this->validate();
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray()
    {
        $requestPrototype = [
            'access_token' => $this->accessToken,
        ];

        if ($this->fields !== null) {
            $requestPrototype['fields'] = json_encode($this->fields);
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
        return 'getAccountInfo';
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
        if ($this->fields !== null && $this->fields === []) {
            throw new InvalidRequestInfoException('fields parameter required at least one value in fields list');
        }
    }
}
