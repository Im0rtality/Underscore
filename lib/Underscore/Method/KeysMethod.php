<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class KeysMethod
 * @package Underscore\Method
 */
class KeysMethod extends UnderscoreMethod
{
    /**
     * Creates an collection composed of the enumerable property keys of object.
     *
     * @SuppressWarnings(UnusedLocalVariable) - $value in foreach
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $newCollection = array();

        foreach ($collection as $key => $value) {
            $newCollection[] = $key;
        }

        return $this->wrap($newCollection);
    }
}
