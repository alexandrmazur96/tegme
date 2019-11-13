<?php

namespace Tegme\Types\Dom;

use Tegme\Types\Dom\Nodes\NodeInterface;

final class DomPage implements DomPageInterface
{
    /** @var NodeInterface[] */
    private $content;

    /**
     * @param NodeInterface[] $content
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /**
     * Calculate and return page size.
     * @return int page size in bytes.
     */
    public function contentLength()
    {
        return strlen(json_encode($this->content));
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->content;
    }

    /**
     * Return page content.
     * @return NodeInterface[]
     */
    public function getContent()
    {
        return $this->content;
    }
}
