<?php

namespace Underscore\Method;

use Underscore\Collection;
use Underscore\UnderscoreMethod;

/**
 * Class AnyMethod
 * @package Underscore\Method
 */
class AnyMethod extends UnderscoreMethod
{
    /**
     * Checks if the $iterator returns a truey value for ANY element of a collection.
     * The function returns as soon as it finds a passing value and does not iterate
     * over entire collection.
     *
     * Returns boolean
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
            if (call_user_func($iterator, $v, $k)) {
                $found = true;
                break;
            }
        }

        return $this->wrap($found);
    }
}
