<?php

namespace Tegme;

use Tegme\Exceptions\InvalidParameterException;
use Tegme\Types\Dom\Nodes\NodeElement;
use Tegme\Types\Dom\Nodes\NodeInterface;
use Tegme\Types\Dom\Tags\TagInterface;

class PageBuilder
{
    /** @var NodeElement[] */
    private $page;

    /** @var NodeElement|null */
    private $lastInsertedNode;

    /** @var NodeElement|null */
    private $lastChildrenNode;

    /**
     * @param TagInterface $tag
     * @param string[]|null $value
     * @return PageBuilder
     */
    public function newTag(TagInterface $tag, array $value = null)
    {
        $tagAttribute = $tag->getAttributes() === null ? null : $tag->getAttributes()->toArray();
        $newNode = new NodeElement($tag->getTag(), $tagAttribute, $value);
        $this->page[] = $newNode;
        $this->lastInsertedNode = $newNode;

        return $this;
    }

    /**
     * @param TagInterface|null $tag
     * @param string[]|string|int|float|bool|null $value
     * @return PageBuilder
     * @throws InvalidParameterException
     */
    public function insertChildrenTag(TagInterface $tag = null, $value = null)
    {
        if ($tag === null && $value === null) {
            throw new InvalidParameterException(
                'When tag inserting - you should pass $tag or $value'
            );
        }

        if (!($this->lastInsertedNode instanceof NodeElement)) {
            throw new InvalidParameterException(
                'You try to insert tag to node, that is value'
            );
        }

        $newNode = $this->buildNode($tag, $value);
        if ($newNode === null) {
            throw new InvalidParameterException(
                'Unable to create node element'
            );
        }

        $this->lastInsertedNode->insertChildren([$newNode]);

        return $this;
    }

    /**
     * @return NodeInterface[]
     */
    public function build()
    {
        return $this->page;
    }
//
//    /**
//     * @param TagInterface|null $tag
//     * @param string[]|null $value
//     * @throws InvalidPageBuilderParameterException
//     */
//    public function insertToLastChildren(TagInterface $tag = null, array $value = null)
//    {
//        if ($this->lastInsertedNode === null && $tag === null) {
//            throw new InvalidPageBuilderParameterException(
//                'Page is empty, tag should not be null in this case'
//            );
//        }
//
//        if ($this->lastInsertedNode === null) {
//            $this->newTag($tag, $value);
//            return;
//        }
//
//        if ($this->lastInsertedNode->getChildren() === null) {
//            $this->insertChildrenTag($tag, $value);
//            return;
//        }
//
//        if ($this->lastChildrenNode === null && $this->lastInsertedNode->getChildren()) {
//            throw new InvalidPageBuilderParameterException(
//                'You try to insert tag to node, that is value'
//            );
//        }
//
//        $newNode = $this->buildNode($tag, $value);
//
//        if ($this->lastChildrenNode === null) {
//            $this->lastChildrenNode = $this->lastInsertedNode->getChildren();
//        }
//
//
////        $lastChildrenTag = $this->lastChildrenNode === null ?
////            $this->lastInsertedNode->getChildren() :
////            $this->lastChildrenNode;
//    }

    /**
     * @param TagInterface|null $tag
     * @param string[]|string|int|float|bool|null $value
     * @return array|NodeElement|null
     */
    private function buildNode(TagInterface $tag = null, $value = null)
    {
        $newChildrenNode = null;

        if ($tag !== null && $value !== null) {
            $value = is_array($value) ? $value : [$value];
            $tagAttribute = $tag->getAttributes() === null ? null : $tag->getAttributes()->toArray();
            $newChildrenNode = new NodeElement($tag->getTag(), $tagAttribute, $value);

            return $newChildrenNode;
        }

        if ($tag !== null) {
            $tagAttribute = $tag->getAttributes() === null ? null : $tag->getAttributes()->toArray();
            $newChildrenNode = new NodeElement($tag->getTag(), $tagAttribute);

            return $newChildrenNode;
        }

        if ($value !== null) {
            $newChildrenNode = is_array($value) ? $value : [$value];
        }

        return $newChildrenNode;
    }
}
