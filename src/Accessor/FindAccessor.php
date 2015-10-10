<?php

namespace Underscore\Accessor;

use Underscore\Accessor;
use Underscore\Collection;

class FindAccessor extends Accessor
{
    /**
     * Iterates over elements of a collection, returning the first element that the callback returns truey for.
     *
     * Returns mixed
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return bool
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        $found = false;
        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $v, $k, $collection)) {
                $found = true;
                break;
            }
        }

        return $found;
    }
}
