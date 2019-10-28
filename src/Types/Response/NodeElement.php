<?php

namespace Tegme\Types\Response;

use Tegme\Types\Node;

/**
 * This object represents a DOM element node.
 * @package Tegme\Types
 */
final class NodeElement extends Node
{
    /**
     * Name of the DOM element.
     *
     * <i>Available tags:</i>
     * a, aside, b, blockquote, br, code, em, figcaption,
     * figure, h3, h4, hr, i, iframe, img, li, ol, p, pre, s, strong, u, ul, video.
     * @var string
     */
    private $tag;

    /**
     * Attributes of the DOM element.
     * Key of object represents name of attribute, value represents value of attribute.
     * <i>Available attributes:</i>
     * href, src.
     * @var array|null <b>OPTIONAL</b>
     */
    private $attrs;

    /**
     * List of child nodes for the DOM element.
     * @var Node[]|null <b>OPTIONAL</b>
     */
    private $children;

    /**
     * NodeElement constructor.
     * @param string $tag
     * @param array|null $attrs
     * @param Node[]|null $children
     */
    public function __construct($tag, array $attrs = null, array $children = null)
    {
        $this->tag = $tag;
        $this->attrs = $attrs;
        $this->children = $children;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @return array|null
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @return Node[]|null
     */
    public function getChildren()
    {
        return $this->children;
    }
}
