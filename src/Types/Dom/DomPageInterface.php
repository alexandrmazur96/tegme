<?php

namespace Tegme\Types\Dom;

use JsonSerializable;

/**
 * @package Tegme\Types
 */
interface DomPageInterface extends JsonSerializable
{
    /**
     * Calculate and return page size.
     * @return int page size in bytes.
     */
    public function contentLength();
}
