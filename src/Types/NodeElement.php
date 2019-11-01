<?php

namespace Tegme\Types;

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
     * @param string $tag
     * @param array|null $attrs
     * @param Node[]|string[]|null $children
     */
    public function __construct($tag, array $attrs = null, array $children = null)
    {
        $this->tag = $tag;
        $this->attrs = $attrs;
        $this->children = $children;
    }


    /**
     * Insert children nodes.
     * When string[] passed - we understand it as node value.
     * @param Node[]|string[] $childrenNode
     */
    public function insertChildren($childrenNode)
    {
        if ($this->getChildren() === null) {
            $this->children = $childrenNode;
        } else {
            $this->children[] = $childrenNode;
        }
    }

    /**
     * Return tag name.
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Return tag attributes.
     * @return array[string]string|null
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * Return children nodes.
     * @return NodeElement[]|null
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Return content length in bytes.
     * @return int
     */
    public function contentLength()
    {
        return strlen(json_encode($this));
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $prototype = [
            'tag' => $this->tag,
        ];

        if ($this->attrs !== null) {
            $prototype['attrs'] = $this->attrs;
        }

        if ($this->children !== null) {
            $prototype['children'] = $this->children;
        }

        return $prototype;
    }
}
