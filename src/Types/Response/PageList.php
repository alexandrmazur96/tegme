<?php

namespace Tegme\Types\Response;

/**
 * This object represents a list of Telegraph articles belonging to an account.
 * Most recently created articles first.
 * @package Tegme\Types
 */
final class PageList
{
    /**
     * Total number of pages belonging to the target Telegraph account.
     * @var int
     */
    private $totalCount;

    /**
     * Requested pages of the target Telegraph account.
     * @var Page[]
     */
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
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @return Page[]
     */
    public function getPages()
    {
        return $this->pages;
    }
}
