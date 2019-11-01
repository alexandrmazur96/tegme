<?php

namespace Tegme\Types\Tags;

use Tegme\Types\Attribute;

class Video implements TagInterface
{
    /** @var Attribute */
    private $attribute;
   
    /**
     * @param Attribute $attribute
     */
    public function __construct($attribute)
    {
        $this->attribute = $attribute;
    }

    /**
     * @inheritDoc
     */
    public function getTag()
    {
        return 'video';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
