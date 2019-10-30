<?php

namespace Tegme\Types\Response;

use JsonSerializable;
use Tegme\Types\Node;

/**
 * This object represents a page on Telegraph.
 * @package Tegme\Types
 */
final class Page implements JsonSerializable
{
    /** @var string */
    private $path;

    /** @var string */
    private $url;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var int */
    private $views;

    /** @var string|null <b>OPTIONAL</b> */
    private $authorName;

    /** @var string|null <b>OPTIONAL</b> */
    private $authorUrl;

    /** @var string|null <b>OPTIONAL</b> */
    private $imageUrl;

    /** @var Node[]|null <b>OPTIONAL</b> */
    private $content;

    /** @var bool|null <b>OPTIONAL</b> */
    private $canEdit;

    /**
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
     * Path to the page.
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * URL of the page.
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Title of the page.
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Description of the page.
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Number of page views for the page.
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Name of the author, displayed below the title.
     * @return string|null
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Profile link, opened when users click on the author's name below the title.
     * Can be any link, not necessarily to a Telegram profile or channel.
     * @return string|null
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }

    /**
     * Image URL of the page.
     * @return string|null
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Content of the page.
     * @return Node[]|null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * True, if the target Telegraph account can edit the page.
     *
     * Note: Only returned if access_token passed.
     *
     * @return bool|null
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $prototype = [
            'path' => $this->getPath(),
            'url' => $this->getUrl(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'views' => $this->getViews(),
        ];

        if ($this->getAuthorName() !== null) {
            $prototype['author_name'] = $this->getAuthorName();
        }

        if ($this->getAuthorUrl() !== null) {
            $prototype['author_url'] = $this->getAuthorUrl();
        }

        if ($this->getImageUrl() !== null) {
            $prototype['image_url'] = $this->getImageUrl();
        }

        if ($this->getContent() !== null) {
            $prototype['content'] = json_encode($this->getContent());
        }

        if ($this->getCanEdit() !== null) {
            $prototype['can_edit'] = $this->getCanEdit();
        }

        return $prototype;
    }
}
