<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class FlattenMethod
 * @package Underscore\Method
 */
class FlattenMethod extends UnderscoreMethod
{
    /**
     * Performs shallow flatten operation on collection (unwraps first level of array)
     *
     * @param Collection $collection
     * @return Collection
     */
    public function __invoke($collection)
    {
        $newCollection = array();

        foreach ($collection as $value) {
            $newCollection = array_merge($newCollection, is_array($value) ? $value : array($value));
        }

        return $this->wrap($newCollection);
    }
}
