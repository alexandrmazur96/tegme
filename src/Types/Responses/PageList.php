<?php

namespace Tegme\Types\Responses;

/**
 * This object represents a list of Telegraph articles belonging to an account.
 * Most recently created articles first.
 * @package Tegme\Types
 */
final class PageList
{
    /** @var int */
    private $totalCount;

    /** @var Page[] */
    private $pages;

    /**
     * PageList constructor.
     * @param int $totalCount
     * @param Page[] $pages
     */
    public function __construct($totalCount, array $pages)
    {
        $this->totalCount = $totalCount;
        $this->pages = $pages;
    }

    /**
     * Total number of pages belonging to the target Telegraph account.
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * Requested pages of the target Telegraph account.
     * @return Page[]
     */
    public function getPages()
    {
        return $this->pages;
    }
}
