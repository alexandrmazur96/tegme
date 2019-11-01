<?php

namespace Tegme\Types\Dom\Tags;

use Tegme\Types\Dom\Attribute;

class Br implements TagInterface
{
    /** @var Attribute[]|null */
    private $attributes;
   
    /**
     * @param Attribute[]|null $attributes
     */
    public function __construct(array $attributes = null)
    {
        $this->attributes = $attributes;
    }

    /**
     * @inheritDoc
     */
    public function getTag()
    {
        return 'br';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
