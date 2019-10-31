<?php

namespace Tegme\Types\Responses;

/**
 * This object represents the number of page views for a Telegraph article.
 * @package Tegme\Types
 */
final class PageViews
{
    /** @var int */
    private $views;

    /**
     * @param int $views
     */
    public function __construct($views)
    {
        $this->views = $views;
    }

    /**
     * Number of page views for the target page.
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }
}
