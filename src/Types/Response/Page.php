<?php

namespace Tegme\Types\Response;

use Tegme\Types\Node;

/**
 * This object represents a page on Telegraph.
 * @package Tegme\Types
 */
final class Page
{
    /**
     * Path to the page.
     * @var string
     */
    private $path;

    /**
     * URL of the page.
     * @var string
     */
    private $url;

    /**
     * Title of the page.
     * @var string
     */
    private $title;

    /**
     * Description of the page.
     * @var string
     */
    private $description;

    /**
     * Number of page views for the page.
     * @var int
     */
    private $views;

    /**
     * Name of the author, displayed below the title.
     * @var string|null <b>OPTIONAL</b>
     */
    private $authorName;

    /**
     * Profile link, opened when users click on the author's name below the title.
     * Can be any link, not necessarily to a Telegram profile or channel.
     * @var string|null <b>OPTIONAL</b>
     */
    private $authorUrl;

    /**
     * Image URL of the page.
     * @var string|null <b>OPTIONAL</b>
     */
    private $imageUrl;

    /**
     * Content of the page.
     * @var Node[]|null <b>OPTIONAL</b>
     */
    private $content;

    /**
     * True, if the target Telegraph account can edit the page.
     *
     * Note: Only returned if access_token passed.
     *
     * @var bool|null <b>OPTIONAL</b>
     */
    private $canEdit;

    /**
     * Page constructor.
     * @param string $path
     * @param string $url
     * @param string $title
     * @param string $description
     * @param int $views
     * @param string|null $authorName
     * @param string|null $authorUrl
     * @param string|null $imageUrl
     * @param Node[]|null $content
     * @param bool|null $canEdit
     */
    public function __construct(
        $path,
        $url,
        $title,
        $description,
        $views,
        $authorName = null,
        $authorUrl = null,
        $imageUrl = null,
        array $content = null,
        $canEdit = null
    ) {
        $this->path = $path;
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->views = $views;
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->imageUrl = $imageUrl;
        $this->content = $content;
        $this->canEdit = $canEdit;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return string|null
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @return string|null
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return Node[]|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return bool|null
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }
}
