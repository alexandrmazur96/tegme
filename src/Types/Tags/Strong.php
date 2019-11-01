<?php

namespace Tegme\Types\Tags;

use Tegme\Types\Attribute;

class Strong implements TagInterface
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
        return 'strong';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
