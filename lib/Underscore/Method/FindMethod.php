<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class FindMethod
 * @package Underscore\Method
 */
class FindMethod extends UnderscoreMethod
{
    /**
     * Iterates over elements of a collection, returning the first element that the callback returns truey for.
     *
     * Returns mixed
     *
     * @param Collection $collection
     * @param callable   $iterator
     * @return Collection
     */
    public function __invoke($collection, $iterator)
    {
        $collection = clone $collection;

        $found = false;
        foreach ($collection as $k => $v) {
            if (call_user_func($iterator, $k, $v, $collection)) {
                $found = true;
                break;
            }
        }

        return $this->wrap($found);
    }
}
