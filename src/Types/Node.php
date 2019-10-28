<?php

namespace Tegme\Types;

use JsonSerializable;

/**
 * This abstract object represents a DOM Node.
 * It can be a String which represents a DOM text node or a NodeElement object.
 * @package Tegme\Types
 * @see NodeElement
 */
abstract class Node implements JsonSerializable
{
    abstract public function contentLength();
}
