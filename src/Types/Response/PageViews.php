<?php

namespace Tegme\Types\Response;

/**
 * This object represents the number of page views for a Telegraph article.
 * @package Tegme\Types
 */
final class PageViews
{
    /**
     * Number of page views for the target page.
     * @var int
     */
    private $views;

    /**
     * PageViews constructor.
     * @param int $views
     */
    public function __construct($views)
    {
        $this->views = $views;
    }

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }
}
