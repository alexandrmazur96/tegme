<?php

namespace Tegme\Types;

use JsonSerializable;

/**
 * Represent HTML attribute in terms of Telegraph API.
 * @package Tegme\Types
 */
final class Attribute implements JsonSerializable
{
    /** @var string */
    private $name;

    /** @var string */
    private $value;

    /**
     * Note, that as for now, Telegraph provide only two possible variant of attributes: <b>href<b> and <b>src</b>
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Associative array where key is attribute and value represents value of attribute. Example:<br>
     * <code>
     *  [
     *      'href' => 'https://example.com'
     *  ]
     * </code>
     *
     * @return array[string]string|null
     */
    public function toArray()
    {
        return [
            $this->name => $this->value,
        ];
    }

    /**
     * Attribute value.
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Attribute name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
