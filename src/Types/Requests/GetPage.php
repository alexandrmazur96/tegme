<?php

namespace Tegme\Types\Requests;

use Tegme\Types\Response\Page;

/**
 * Use this method to get a Telegraph page.
 * @package Tegme\Types\Requests
 * @see Page returns a Page object on success.
 */
final class GetPage extends BaseRequest
{
    /** @var string */
    private $path;

    /** @var bool|null */
    private $returnContent;

    /**
     * @param string $path              Path to the Telegraph page (in the format
     *                                  Title-12-31, i.e. everything that comes after http://telegra.ph/).
     *
     * @param bool|null $returnContent  If true, content field will be returned in Page object.
     */
    public function __construct($path, $returnContent = null)
    {
        $this->path = $path;
        $this->returnContent = $returnContent;
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
        $requestPrototype = [];

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
        return true;
    }

    /**
     * Return method name, which would be queried by this request.
     *
     * @return string
     * @link https://telegra.ph/api list of available methods you can find here.
     */
    public function getMethod()
    {
        return 'getPage';
    }

    /**
     * Return path if exists.
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Nothing to validate in this request.
     * @return void
     * @link https://telegra.ph/api all information about valid request fields you can find here.
     */
    protected function validate()
    {
    }
}
