<?php

namespace Tegme\Types\Dom\Nodes;

use Tegme\Types\Dom\Attribute;
use Tegme\Types\Dom\Tags\TagInterface;

/**
 * This object represents a DOM element node.
 * @package Tegme\Types
 */
final class NodeElement implements NodeInterface
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
     * List of child nodes for the DOM element.
     * @var NodeInterface[]|null <b>OPTIONAL</b>
     */
    private $children;

    /**
     * @param TagInterface $tag
     * @param NodeInterface|NodeInterface[]|null $children
     */
    public function __construct(TagInterface $tag, $children = null)
    {
        $this->tag = $tag;
        if ($children !== null) {
            if (!is_array($children)) {
                $this->children = [$children];
            } else {
                $this->children = $children;
            }
        }
    }

    /**
     * Insert new children node.
     * @param NodeInterface $node
     */
    public function addChildren(NodeInterface $node)
    {
        if ($this->children === null) {
            $this->children = [$node];
        } else {
            $this->children[] = $node;
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
     * @return Attribute[]|null
     */
    public function getAttrs()
    {
        return $this->tag->getAttributes();
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
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $prototype = [
            'tag' => $this->tag->getTag(),
        ];

        if ($this->tag->getAttributes() !== null) {
            $prototype['attrs'] = $this->buildAttributesArray();
        }

        if ($this->children !== null) {
            $prototype['children'] = $this->children;
        }

        return $prototype;
    }

    /**
     * Build attribute array representation in terms of Telegraph API.
     * @return array[string]string
     */
    private function buildAttributesArray()
    {
        $attrs = [];
        foreach ($this->tag->getAttributes() as $attribute) {
            $attrs[$attribute->getName()] = $attribute->getValue();
        }

        return $attrs;
    }
}
