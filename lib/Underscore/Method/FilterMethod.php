<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class FilterMethod
 * @package Underscore\Method
 */
class FilterMethod extends UnderscoreMethod
{
    /**
     * Iterates over elements of a collection, returning an array of all elements the callback returns truey for.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        foreach ($collection as $k => $v) {
            if (!call_user_func($iterator, $v, $k)) {
                unset($collection[$k]);
            }
        }

        return $collection;
    }
}
