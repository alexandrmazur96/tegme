<?php

namespace Tegme\Types\Dom\Tags;

use Tegme\Types\Dom\Attribute;

class S implements TagInterface
{
    /** @var Attribute[]|null */
    private $attributes;
   
    /**
     * @param Attribute[]|null $attributes
     */
    public function __construct(array $attributes = null)
    {
        if ($attributes !== null) {
            foreach ($attributes as $name => $value) {
                if (is_scalar($value)) {
                    $this->attributes[] = new Attribute($name, $value);
                } else {
                    $this->attributes[] = $value;
                }
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getTag()
    {
        return 's';
    }
    
    /**
     * @inheritDoc
     */
    public function getAttributes()
    {
        return $this->attributes;
    }
}
