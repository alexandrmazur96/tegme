<?php

namespace Tegme\Builders;

use Tegme\Types\Dom\DomPage;
use Tegme\Types\Dom\Nodes\NodeElement;
use Tegme\Types\Dom\Nodes\NodeInterface;
use Tegme\Types\Dom\Nodes\NodeText;
use Tegme\Types\Dom\Tags\TagInterface;

class DomPageBuilder
{
    /** @var array[string]NodeInterface */
    private $nodeMap;

    /** @var NodeInterface[] */
    private $content;

    public function __construct()
    {
        $this->cleanUp();
    }

    /**
     * Create new DomPage instance.
     * @return DomPage
     */
    public function build()
    {
        $domPage = new DomPage($this->content);

        $this->cleanUp();

        return $domPage;
    }

    /**
     * Add new node element to the top-level of the page.
     *
     * If you have a plan to attach children(-s) to this new node - you should provide $newNodeId parameter.
     *
     * If $newNodeId parameter passed - it should be unique on the page,
     * otherwise it can be overwritten by last added node with same ID.
     *
     * @param TagInterface $tag tag for new node element.
     * @param string|null $newNodeId identifier for new node element.
     * @return NodeInterface new created node element.
     */
    public function addNewNode(TagInterface $tag, $newNodeId = null)
    {
        $node = new NodeElement($tag);

        if ($newNodeId !== null) {
            $this->nodeMap[$newNodeId] = $node;
        }

        $this->content[] = $node;

        return $node;
    }

    /**
     * Add new node element with value to the top-level of the page.
     *
     * If you have a plan to attach children(-s) to this new node - you should provide $newNodeId parameter.
     *
     * If $newNodeId parameter passed - it should be unique on the page,
     * otherwise it can be overwritten by last added node with same ID.
     *
     * @param TagInterface $tag new node tag.
     * @param int|float|bool|string $value value for text node.
     * @param string|null $newNodeId identifier for new node element.
     * @return NodeInterface new create node element.
     */
    public function addNewNodeWithValue(TagInterface $tag, $value, $newNodeId = null)
    {
        $node = new NodeElement($tag, new NodeText($value));

        if ($newNodeId !== null) {
            $this->nodeMap[$newNodeId] = $node;
        }

        $this->content[] = $node;

        return $node;
    }

    /**
     * Add new children node element to the indicated by $nodeId node.
     *
     * If you have a plan to attach children(-s) to this new node - you should provide $newNodeId parameter.
     *
     * If $newNodeId parameter passed - it should be unique on the page,
     * otherwise it can be overwritten by last added node with same ID.
     *
     * @param string $nodeId existing node identifier. Should be presented, otherwise null will be returned.
     * @param TagInterface $tag tag for new children node element.
     * @param string|null $newNodeId identifier for new children node.
     * @return NodeInterface|null null returned if no element presented with given ID.
     */
    public function addChildrenNodeElement($nodeId, TagInterface $tag, $newNodeId = null)
    {
        if (!isset($this->nodeMap[$nodeId])) {
            return null;
        }

        $newNodeElement = new NodeElement($tag);

        /** @var NodeElement $nodeElement */
        $nodeElement = $this->nodeMap[$nodeId];
        $nodeElement->addChildren($newNodeElement);

        if ($newNodeId !== null) {
            $this->nodeMap[$newNodeId] = $newNodeElement;
        }

        return $newNodeElement;
    }

    /**
     * Add new children node element to the indicated by $nodeId node.
     *
     * Note that node text can't have identifiers - you can't attach children(-s) to this type of NodeInterface.
     *
     * @param string $nodeId existing node identifier. Should be presented, otherwise null will be returned.
     * @param int|float|bool|string $value value for new children node text.
     * @return NodeInterface|null null returned if no element presented with given ID.
     */
    public function addChildrenNodeText($nodeId, $value)
    {
        if (!isset($this->nodeMap[$nodeId])) {
            return null;
        }

        $newNodeText = new NodeText($value);

        /** @var NodeElement $nodeElement */
        $nodeElement = $this->nodeMap[$nodeId];
        $nodeElement->addChildren($newNodeText);

        return $newNodeText;
    }

    /**
     * Set default values to internal properties.
     * @return void
     */
    private function cleanUp()
    {
        $this->nodeMap = [];
        $this->content = [];
    }
}
