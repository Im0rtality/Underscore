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
        $iterator = function ($accumulator, $item) use ($iterator) {
            $accumulator = $accumulator || $iterator($item);
            return $accumulator;
        };

        $reduce = new ReduceMethod();

        return $reduce($collection, $iterator, false);
    }
}
