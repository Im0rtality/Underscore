<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class RejectMethod
 * @package Underscore\Method
 */
class RejectMethod extends UnderscoreMethod
{
    /**
     * The opposite of filter(). This method returns the elements of a collection that the callback
     * does **not** return truey for.
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $v, $k)) {
                unset($collection[$k]);
            }
        }

        return $collection;
    }
}
