<?php

namespace Tegme\Types\Tags;

use Tegme\Types\Attribute;

class Li implements TagInterface
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
        return 'li';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
