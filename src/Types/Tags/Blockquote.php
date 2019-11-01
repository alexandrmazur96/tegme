<?php

namespace Tegme\Types\Tags;

use Tegme\Types\Attribute;

class Blockquote implements TagInterface
{
    /** @var Attribute|null */
    private $attribute;
   
    /**
     * @param Attribute|null $attribute
     */
    public function __construct($attribute = null)
    {
        $this->attribute = $attribute;
    }

    /**
     * @inheritDoc
     */
    public function getTag()
    {
        return 'blockquote';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
