<?php

namespace Tegme\Types\Requests;

use Tegme\Exceptions\InvalidRequestInfoException;
use Tegme\Types\Dom\DomPageInterface;
use Tegme\Types\Responses\Page;

/**
 * Use this method to create a new Telegraph page.
 * @package Tegme\Types\Requests
 * @see Page on success, returns a Page object.
 */
final class CreatePage extends BaseRequest
{
    /** @var string */
    private $accessToken;

    /** @var string */
    private $title;

    /** @var string|null */
    private $authorName;

    /** @var string|null */
    private $authorUrl;

    /** @var bool|null */
    private $returnContent;
    /**
     * @var DomPageInterface
     */
    private $content;

    /**
     * @param string $accessToken Access token of the Telegraph account.
     *
     * @param string $title Page title.
     *
     * @param DomPageInterface $content Content of the page.
     *
     * @param string|null $authorName Author name, displayed below the article's title.
     *
     * @param string|null $authorUrl Profile link, opened when users click on the author's
     *                                  name below the title. Can be any link,
     *                                  not necessarily to a Telegram profile or channel.
     *
     * @param bool|null $returnContent If true, a content field will be returned in the Page object
     *
     * @throws InvalidRequestInfoException look at exception to see what exactly wrong.
     *
     * @link https://telegra.ph/api#Content-format about telegra.ph content format.
     *
     * @see Page successfull result will return Page object.
     */
    public function __construct(
        $accessToken,
        $title,
        DomPageInterface $content,
        $authorName = null,
        $authorUrl = null,
        $returnContent = null
    ) {
        $this->accessToken = $accessToken;
        $this->title = $title;
        $this->content = $content;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->returnContent = $returnContent;
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
            'title' => $this->title,
            'content' => json_encode($this->content),
        ];

        if ($this->authorName !== null) {
            $requestPrototype['author_name'] = $this->authorName;
        }

        if ($this->authorUrl !== null) {
            $requestPrototype['author_url'] = $this->authorUrl;
        }

        if ($this->returnContent !== null) {
            $requestPrototype['return_content'] = $this->returnContent;
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
        return 'createPage';
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
        $titleLength = mb_strlen($this->title);
        if ($titleLength < 1 || $titleLength > 256) {
            throw new InvalidRequestInfoException('title parameter should be between 1 and 256 characters.');
        }

        if ($this->authorName !== null && mb_strlen($this->authorName) > 128) {
            throw new InvalidRequestInfoException('author_name parameter should be between 0 and 128 characters.');
        }

        if ($this->authorUrl !== null && mb_strlen($this->authorUrl) > 512) {
            throw new InvalidRequestInfoException('author_url parameter should be between 0 and 512 characters.');
        }

        $usedBytes = $this->content->contentLength();

        // 64 Kbytes
        $maxContentLength = 65536;
        if ($usedBytes > $maxContentLength) {
            throw new InvalidRequestInfoException(
                'content parameter should be up to 64 KB - ' .
                round(($usedBytes / 1024), 2) .
                ' KB given'
            );
        }
    }
}
