<?php

namespace Tegme\Types\Dom\Nodes;

final class NodeText implements NodeInterface
{
    /** @var string */
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->content;
    }
}
