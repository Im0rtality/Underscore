<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class ValuesMethod
 * @package Underscore\Method
 */
class ValuesMethod extends UnderscoreMethod
{
    /**
     * Creates an collection composed of the enumerable property values of object.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $newCollection = array();

        foreach ($collection as $value) {
            $newCollection[] = $value;
        }

        return $this->wrap($newCollection);
    }
}
