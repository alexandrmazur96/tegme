<?php

namespace Tegme\Types\Dom\Nodes;

use JsonSerializable;

/**
 * This abstract object represents a DOM Node.
 * It can be a String which represents a DOM text node or a NodeElement object.
 * @package Tegme\Types
 * @see NodeElement
 * @see NodeText
 */
interface NodeInterface extends JsonSerializable
{
}
