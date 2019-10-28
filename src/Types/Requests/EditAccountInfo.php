<?php

namespace Tegme\Types\Requests;

use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Types\Response\Account;

/**
 * Use this method to update information about a Telegraph account.
 * Pass only the parameters that you want to edit.
 * @package Tegme\Types\Requests
 * @see Account on success, returns an Account object with the default fields.
 */
final class EditAccountInfo extends BaseRequest
{
    /** @var string */
    private $accessToken;

    /** @var string|null */
    private $shortName;

    /** @var string|null */
    private $authorName;

    /** @var string|null */
    private $authorUrl;

    /**
     * @param string $accessToken       Access token of the Telegraph account.
     * @param string|null $shortName    New account name.
     *
     * @param string|null $authorName   New default author name used when creating new articles.
     *
     * @param string|null $authorUrl    New default profile link, opened when users click on
     *                                  the author's name below the title.
     *                                  Can be any link, not necessarily to a Telegram profile or channel.
     *
     * @throws InvalidRequestInfoException look at exception to see what exactly wrong.
     */
    public function __construct($accessToken, $shortName = null, $authorName = null, $authorUrl = null)
    {
        $this->accessToken = $accessToken;
        $this->shortName = $shortName;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
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

        if ($this->shortName !== null) {
            $requestPrototype['short_name'] = $this->shortName;
        }

        if ($this->authorName !== null) {
            $requestPrototype['author_name'] = $this->authorName;
        }

        if ($this->authorUrl !== null) {
            $requestPrototype['author_url'] = $this->authorUrl;
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
        return 'editAccountInfo';
    }

    /**
     * Validate request information before making request.
     * @return void
     * @throws InvalidRequestInfoException
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    protected function validate()
    {
        $shortNameLength = mb_strlen($this->shortName);
        if ($shortNameLength < 1 || $shortNameLength > 32) {
            throw new InvalidRequestInfoException('short_name parameter should be between 1 and 32 characters.');
        }

        if ($this->authorName !== null && mb_strlen($this->authorName) > 128) {
            throw new InvalidRequestInfoException('author_name parameter should be between 0 and 128 characters.');
        }

        if ($this->authorUrl !== null && mb_strlen($this->authorUrl) > 512) {
            throw new InvalidRequestInfoException('author_url parameter should be between 0 and 512 characters.');
        }
    }
}
